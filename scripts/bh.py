import sys

q = chr(39)
at = chr(64)
ob = chr(123)
cb = chr(125)

home = f"""
{at}extends({q}layouts.app{q})
{at}section({q}title{q}, {q}urca - الوجهة الاولى للطابعات والاكسسوارات التقنية{q})

{at}push({q}styles{q})
<link rel="stylesheet" href="{ob}{ob} asset({q}css/printer-loader.css{q}) {cb}{cb}">
{at}endpush

{at}section({q}content{q})

<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="4"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{ob}{ob} asset({q}images/slide-1.jpg{q}) {cb}{cb}" class="d-block w-100 hero-img" alt="Slide 1">
        </div>
        <div class="carousel-item">
            <img src="{ob}{ob} asset({q}images/slide-2.jpg{q}) {cb}{cb}" class="d-block w-100 hero-img" alt="Slide 2">
        </div>
        <div class="carousel-item">
            <img src="{ob}{ob} asset({q}images/slide-3.jpg{q}) {cb}{cb}" class="d-block w-100 hero-img" alt="Slide 3">
        </div>
        <div class="carousel-item">
            <img src="{ob}{ob} asset({q}images/slide-4.jpg{q}) {cb}{cb}" class="d-block w-100 hero-img" alt="Slide 4">
        </div>
        <div class="carousel-item">
            <img src="{ob}{ob} asset({q}images/slide-5.jpg{q}) {cb}{cb}" class="d-block w-100 hero-img" alt="Slide 5">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
</div>

{at}endsection
"""

with open('resources/views/home.blade.php', 'w', encoding='utf-8') as f:
    f.write(home.lstrip())

import os
print('Written:', os.path.getsize('resources/views/home.blade.php'), 'bytes')
