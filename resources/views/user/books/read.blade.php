@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $book->title }}</h2>
    <div class="mb-3">
        <button onclick="goPrevious()" class="btn btn-dark">Previous</button>
        <span>Page: <span id="page_num">1</span> / <span id="page_count">?</span></span>
        <button onclick="goNext()" class="btn btn-secondary">Next</button>
        <input type="number" id="jump_page" placeholder="Jump to page" style="width: 80px;" class="mx-2"/>
        <button onclick="jumpToPage()" class="btn btn-primary">Go</button>
        <button onclick="zoomIn()" class="btn btn-info mx-1"><i class="fas fa-search-plus"></i> Zoom In</button>
        <button onclick="zoomOut()" class="btn btn-info mx-1"><i class="fas fa-search-minus"></i> Zoom Out</button>
        {{-- <a href="{{ url('/books/' . $book->id) }}" class="btn btn-danger btn-exit-custom">Exit</a> --}}
        <button onclick="exitWithSave()" class="btn btn-danger btn-exit-custom">Exit</button>
    </div>
    <div class="pdf-container">
        <canvas id="pdf-render"></canvas>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
<style>
    .pdf-container {
        width: 100%;
        overflow: auto;
        border: 1px solid #ddd;
        margin: 0 auto;
        max-height: 80vh;
        padding: 20px;
        background-color: #f5f5f5;
    }
    #pdf-render {
        display: block;
        margin: 0 auto;
        background-color: white;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .btn-exit-custom {
        float: right;
    }
</style>

<script>
    let bookId = {{ $book->id }};
    let currentPage = {{ $currentPage }};

    function autoSaveProgress() {
        fetch(`/books/${bookId}/save-progress?page=${pageNum}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ page: pageNum })
        }).then(response => {
            if (response.ok) {
                console.log('Auto-saved page:', pageNum);
            } else {
                console.warn('Failed to auto-save progress');
            }
        }).catch(err => {
            console.error('Auto-save error:', err);
        });
    }

    // Set interval to auto-save every minute (60000 ms)
    setInterval(autoSaveProgress, 60000);

    function exitWithSave() {
        fetch(`/books/{{ $book->id }}/save-progress?page=${pageNum}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ page: pageNum })
        }).finally(() => {
            window.location.href = "{{ url('/books/' . $book->id) }}";
        });
    }



    const url = "{{ asset('storage/' . $book->pdf_path) }}";
    let pdfDoc = null,
        pageNum = {{ $currentPage }},
        pageIsRendering = false,
        pageNumIsPending = null,
        scale = 1.5; // Higher base scale

    const canvas = document.querySelector('#pdf-render'),
          ctx = canvas.getContext('2d');

    // Enhanced zoom functions
    const zoomIn = () => {
        if (scale >= 3) return;
        scale += 0.25;
        renderPage(pageNum); // Direct render for better quality
    };

    const zoomOut = () => {
        if (scale <= 0.5) return;
        scale -= 0.25;
        renderPage(pageNum); // Direct render for better quality
    };

    const renderPage = num => {
        pageIsRendering = true;

        pdfDoc.getPage(num).then(page => {
            const viewport = page.getViewport({ scale });
            
            // Set canvas dimensions with higher resolution
            const outputScale = window.devicePixelRatio || 1;
            canvas.height = Math.floor(viewport.height * outputScale);
            canvas.width = Math.floor(viewport.width * outputScale);
            canvas.style.height = Math.floor(viewport.height) + "px";
            canvas.style.width = Math.floor(viewport.width) + "px";

            const transform = outputScale !== 1 
                ? [outputScale, 0, 0, outputScale, 0, 0] 
                : null;

            const renderCtx = {
                canvasContext: ctx,
                transform,
                viewport,
                intent: 'print' // Changed to print for better quality
            };

            page.render(renderCtx).promise.then(() => {
                pageIsRendering = false;
                if (pageNumIsPending !== null) {
                    renderPage(pageNumIsPending);
                    pageNumIsPending = null;
                }
            });

            document.querySelector('#page_num').textContent = num;
        });
    };

    const queueRenderPage = num => {
        if (pageIsRendering) {
            pageNumIsPending = num;
        } else {
            renderPage(num);
        }
    };

    const goPrevious = () => {
        if (pageNum <= 1) return;
        pageNum--;
        queueRenderPage(pageNum);
    };

    const goNext = () => {
        if (pageNum >= pdfDoc.numPages) return;
        pageNum++;
        queueRenderPage(pageNum);
    };

    const jumpToPage = () => {
        const target = parseInt(document.getElementById("jump_page").value);
        if (!isNaN(target) && target >= 1 && target <= pdfDoc.numPages) {
            pageNum = target;
            queueRenderPage(pageNum);
        }
    };

    pdfjsLib.getDocument(url).promise.then(pdfDoc_ => {
        pdfDoc = pdfDoc_;
        document.querySelector('#page_count').textContent = pdfDoc.numPages;
        renderPage(pageNum);
    });

    window.addEventListener('beforeunload', function () {
        fetch(`/books/{{ $book->id }}/save-progress?page=${pageNum}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ page: pageNum })
        });
    });

</script>
<style>
    .btn-exit-custom {
        
        float: right;
    }
@endsection
