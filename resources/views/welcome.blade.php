<x-public-layout title="Főoldal">
    <section
        class="public-hero public-hero-photo"
        style="--public-hero-image: url('{{ asset(
            'images/alpaka-hero.png'
        ) }}');"
    >
        <div class="public-container public-hero-content">
            <div class="public-hero-copy">
                <p class="public-eyebrow">
                    Alpakaélmény kicsiknek és nagyoknak
                </p>

                <h1>
                    Ismerd meg alpakáinkat testközelből!
                </h1>

                <p>
                    Látogass el családi farmunkra, etesd meg
                    alpakáinkat, és tölts el velük egy nyugodt,
                    emlékezetes délutánt.
                </p>

                <div class="public-actions">
                    <a
                        class="public-button public-button-light"
                        href="{{ route('bookings.create') }}"
                    >
                        Időpontot foglalok
                    </a>

                    <a
                        class="public-button public-button-outline"
                        href="{{ route('products.index') }}"
                    >
                        Webshop
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="public-section public-section-white">
        <div class="public-container">
            <div class="public-section-heading">
                <p class="public-eyebrow">A farmunk</p>

                <h2>Egy hely, ahol lelassulhatsz</h2>

                <p>
                    Családi gazdaságunkban az állatok jólléte
                    és a nyugodt, személyes látogatói élmény
                    áll a középpontban.
                </p>
            </div>

            <a
                class="public-button public-button-outline"
                href="{{ route('about') }}"
            >
                Ismerd meg a farmot
            </a>
        </div>
    </section>

    <section
        class="public-section public-experiences-section"
        style="--public-experiences-image: url('{{ asset(
            'images/alpaka-experiences.png'
        ) }}');"
    >
        <div class="public-container">
            <div class="public-section-heading">
                <p class="public-eyebrow">
                    Programok
                </p>

                <h2>Mit csinálhatsz nálunk?</h2>

                <p>
                    Ismerd meg az alpakákat egy nyugodt,
                    kis létszámú program keretében.
                </p>
            </div>

            <div class="public-grid-3">
                <article class="public-card">
                    <h3>Alpakák etetése</h3>

                    <p>
                        Megismerheted kedvenc csemegéiket,
                        és kézből is megetetheted őket.
                    </p>
                </article>

                <article class="public-card">
                    <h3>Vezetett farmbejárás</h3>

                    <p>
                        Bemutatjuk az alpakák életét,
                        viselkedését és mindennapi gondozását.
                    </p>
                </article>

                <article class="public-card">
                    <h3>Családi program</h3>

                    <p>
                        Kis létszámú, nyugodt program gyerekeknek,
                        családoknak és baráti társaságoknak.
                    </p>
                </article>
            </div>
        </div>
    </section>

    <section class="public-info-band">
        <div class="public-container public-grid-3">
            <div>
                <strong>60–90 perc</strong>
                Egy átlagos látogatás időtartama
            </div>

            <div>
                <strong>Legfeljebb 10 fő</strong>
                Családias, kis létszámú alkalmak
            </div>

            <div>
                <strong>Előzetes foglalás</strong>
                Így minden látogatóra jut időnk
            </div>
        </div>
    </section>

    <section
        class="public-section public-cta-parallax"
        style="--public-cta-image: url('{{ asset(
            'images/alpaka-cta.png'
        ) }}');"
    >
        <div class="public-container public-cta-content">
            <div class="public-section-heading">
                <p class="public-eyebrow">
                    Találkozz velük személyesen
                </p>

                <h2>Készen állsz az alpakaélményre?</h2>

                <p>
                    Válassz megfelelő időpontot, és küldd el
                    foglalási igényedet néhány perc alatt.
                </p>
            </div>

            <a
                class="public-button public-button-light"
                href="{{ route('bookings.create') }}"
            >
                Időpontfoglalás
            </a>
        </div>
    </section>
</x-public-layout>