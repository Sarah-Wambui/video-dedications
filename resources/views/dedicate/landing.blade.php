@extends('layouts.app')


@section('content')
<section class="landing-section">
    <div class="hero">
        <div class="container her0-container">
            <div class="row justify-content-center">
                <div class="col-md-10 text-center">
                    <h1 class="text-4xl md:text-5xl font-semibold hero-heading">Dedicate a Moment of Kindness.</h1>
                    <p class="lead">Sponsor a short video that lifts someone’s heart and spreads the Rabbi’s teachings to thousands.
                      For a refuah, in memory, or in honor—your dedication becomes light in someone’s feed today.</p>
                    <p class="par-2">This isn’t an ad. It’s a mitzvah in motion. Your dedication appears on a video and helps us share Torah and kindness further.</p>
                    <div class="mt-8 d-flex justify-content-center">
                        <a class="hero-link" href="#">
                            <button class="btn hero-btn" tabindex="0">Dedicate a Video →</button>
                        </a>
                    </div>      
                </div>
            </div>
        </div>
    </div>
    <div class="why-it-matters">
        <div class="container">
            <h2  class="matter-text">Why it matters</h2>
            <div class="matter-grid gap-5">
                <div class="matter-card">
                    <div  class="matter-card-header">Spread Torah &amp; kindness</div>
                    <p class="matter-card-text">Your dedication fuels another ripple of light.</p>
                </div>
                <div class="matter-card">
                    <div class="matter-card-header">Honor with meaning</div>
                    <p class="matter-card-text">In honor, memory, or refuah — marked with dignity.</p>
                </div>
                <div class="matter-card">
                    <div class="matter-card-header">Real impact</div>
                    <p class="matter-card-text">We share the message where people actually see it.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="how-it-works">
        <div class="how-it-works-container container">
            <h2 class="how-it-works-header">How it works</h2>
            <div class="works-grids">
                <div class="works-grid" data-testid="step-1">
                    <div class="works-grid-number">1</div>
                    <div class="works-grid-text">Choose dedication</div>
                </div>
                <div class="works-grid" data-testid="step-2">
                    <div class="works-grid-number">2</div>
                    <div class="works-grid-text">Add name &amp; short note</div>
                </div>
                <div class="works-grid" data-testid="step-3">
                    <div class="works-grid-number">3</div>
                    <div class="works-grid-text">Contribute ($180)</div>
                </div>
                <div class="works-grid" data-testid="step-4">
                    <div class="works-grid-number">4</div>
                    <div class="works-grid-text">We publish &amp; notify you</div>
                </div>
            </div>
            <p class="how-it-works-text">No pressure, no upsells. Just light.</p>
        </div>
    </div>
    <div class="landing-quote" style="background: white; border-top: 1px solid var(--brand-cream-3); border-bottom: 1px solid var(--brand-cream-3);">
        <p class="text-center italic max-w-3xl mx-auto text-[var(--brand-teal)] text-lg">"A small light can push away much darkness."</p>
    </div>
</section>


@endsection
