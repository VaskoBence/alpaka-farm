<x-public-layout title="Kapcsolat">
    <section class="public-section public-contact-page">
        <div class="public-container">
            <header class="public-section-heading">
                <p class="public-eyebrow">
                    Lépj kapcsolatba velünk
                </p>

                <h1>Kapcsolat</h1>

                <p>
                    Kérdésed van a látogatással, foglalással
                    vagy valamelyik termékünkkel kapcsolatban?
                    Írj vagy keress minket telefonon!
                </p>
            </header>

            <div class="public-contact-grid">
                <article class="public-content-card public-contact-card">
                    <h2>Elérhetőségeink</h2>

                    <p class="public-contact-intro">
                        A farm kizárólag előzetes időpontfoglalással
                        látogatható.
                    </p>

                    <dl class="public-contact-details">
                        <div class="public-contact-detail">
                            <dt>Cím</dt>

                            <dd>
                                0000 Zöldliget<br>
                                Alpaka köz 1.<br>
                                <small>Fiktív bemutatócím</small>
                            </dd>
                        </div>

                        <div class="public-contact-detail">
                            <dt>E-mail</dt>

                            <dd>
                                <a href="mailto:hello@alpakafarm.example">
                                    hello@alpakafarm.example
                                </a>
                            </dd>
                        </div>

                        <div class="public-contact-detail">
                            <dt>Telefon</dt>

                            <dd>
                                +36 00 000 0000
                            </dd>
                        </div>

                        <div class="public-contact-detail">
                            <dt>Nyitvatartás</dt>

                            <dd>
                                Hétfő–vasárnap: 10:00–17:00
                            </dd>
                        </div>
                    </dl>

                    <div class="public-actions">
                        <a
                            class="public-button"
                            href="{{ route('bookings.create') }}"
                        >
                            Időpontot foglalok
                        </a>

                        <a
                            class="public-button public-button-outline"
                            href="mailto:hello@alpakafarm.example"
                        >
                            E-mailt írok
                        </a>
                    </div>

                    <p class="public-demo-note">
                        Ez egy portfólióprojekt. A megjelenített cím,
                        telefonszám és e-mail-cím nem valós elérhetőség.
                    </p>
                </article>

                <article class="public-map-card">
                    <iframe
                        class="public-map-frame"
                        src="https://www.google.com/maps?q=Pilis-hegys%C3%A9g,+Magyarorsz%C3%A1g&z=10&output=embed"
                        title="Az Alpaka Farm tervezett térsége"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="strict-origin-when-cross-origin"
                    ></iframe>

                    <div class="public-map-description">
                        <p class="public-eyebrow">
                            Tervezett helyszín
                        </p>

                        <h2>A Pilis térségében</h2>

                        <p>
                            A térkép csak a választott régiót mutatja,
                            nem egy valódi farm vagy magánszemély címét.
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </section>
</x-public-layout>