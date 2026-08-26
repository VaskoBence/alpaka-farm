<x-public-layout title="Farmunk">
    <section
        class="public-section public-page-background"
        style="--public-page-image: url('{{ asset('images/farmunk-background.png') }}');"
    >
        <div class="public-container">
            <div class="public-section-heading">
                <p class="public-eyebrow">Farmunk</p>

                <h1>Ismerd meg az Alpakafarm lakóit</h1>

                <p>
                    Kis létszámú családi farmként minden állatunkat
                    név szerint ismerjük, és a látogatásokat is
                    nyugodt, személyes formában szervezzük.
                </p>
            </div>

            <div class="public-alpaca-grid">
                <article class="public-alpaca-card">
                    <img
                        class="public-alpaca-image"
                        src="{{ asset('images/alpaka-krem.png') }}"
                        alt="Vattacukor, a krémszínű alpaka"
                    >

                    <div class="public-alpaca-copy">
                        <h3>Vattacukor</h3>
                        <p>
                            Nyugodt és kíváncsi alpaka, aki különösen
                            szereti a látogatóktól kapott finomságokat.
                        </p>
                    </div>
                </article>

                <article class="public-alpaca-card">
                    <img
                        class="public-alpaca-image"
                        src="{{ asset('images/alpaka-barna.png') }}"
                        alt="Al Pacino, a barna alpaka"
                    >

                    <div class="public-alpaca-copy">
                        <h3>Al Pacino</h3>
                        <p>
                            A csapat legbarátságosabb tagja, aki általában
                            elsőként érkezik a kerítéshez.
                        </p>
                    </div>
                </article>

                <article class="public-alpaca-card">
                    <img
                        class="public-alpaca-image"
                        src="{{ asset('images/alpaka-szurke.png') }}"
                        alt="Kebab, a szürke alpaka"
                    >

                    <div class="public-alpaca-copy">
                        <h3>Kebab</h3>
                        <p>
                            Kissé visszafogottabb, de hamar feloldódik,
                            ha nyugodtan és türelmesen közelítenek hozzá.
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="public-section">
        <div class="public-container public-detail-grid">
            <div>
                <div class="public-section-heading">
                    <h2>Állatbarát látogatások</h2>
                </div>

                <p>
                    Az alpakák nem simogatóállatok, ezért mindig
                    ők döntik el, mennyire szeretnének közel jönni.
                    A látogatások során megmutatjuk, hogyan lehet
                    nyugodtan és biztonságosan kapcsolatba kerülni
                    velük.
                </p>
            </div>

            <div class="public-card">
                <h3>Fontos tudnivalók</h3>

                <ul>
                    <li>Az állatokat csak a kapott eledellel etetjük.</li>
                    <li>Kutyát nem lehet behozni a karámokhoz.</li>
                    <li>Gyerekek csak felnőtt kíséretével vehetnek részt.</li>
                    <li>Rossz idő esetén új időpontot egyeztetünk.</li>
                </ul>
            </div>
        </div>
    </section>
</x-public-layout>