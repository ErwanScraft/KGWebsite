<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">

  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, viewport-fit=cover"
  >

  <meta
    name="theme-color"
    content="#08080a"
  >

  <meta
    name="description"
    content="KGSMP — Minecraft Survival Server. Build, explore, survive."
  >

  <meta
    name="robots"
    content="index, follow"
  >

  <link rel="icon" type="image/webp" href="assets/images/icon.webp">
  <link rel="apple-touch-icon" href="assets/images/icon.webp">

  <title>KGSMP — Minecraft Survival Server</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link
    href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap"
    rel="stylesheet"
  >

  <link rel="stylesheet" href="assets/css/base.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <link rel="stylesheet" href="assets/css/sections.css">
  <link rel="stylesheet" href="assets/css/devices/tablet.css">
  <link rel="stylesheet" href="assets/css/devices/desktop.css">
</head>

<body>

  <header class="site-header" data-header>
    <div class="container header-inner">

      <a
        class="brand"
        href="#top"
        aria-label="KGSMP Home"
      >
        <img
          class="brand-logo"
          src="assets/images/icon.webp"
          alt="KGSMP"
        >
        <span>SURVIVAL S1</span>
      </a>

      <button
        class="nav-toggle"
        type="button"
        aria-label="Buka menu"
        aria-expanded="false"
        aria-controls="site-navigation"
        data-nav-toggle
      >
        <span></span>
        <span></span>
        <span></span>
      </button>

      <nav
        class="site-nav"
        id="site-navigation"
        aria-label="Navigasi utama"
        data-nav
      >
        <a class="is-active" href="#top">Home</a>
        <a href="#server">Server</a>
        <a href="#features">Features</a>
        <a href="#faq">FAQ</a>
      </nav>

      <a
        class="button button--small button--primary header-cta"
        href="#server"
      >
        Play Now
      </a>

    </div>
  </header>


  <main>

    <!-- Hero -->
    
    <section
      class="hero"
      id="top"
      aria-labelledby="hero-title"
    >
      <div class="container hero-content">
    
        <p class="eyebrow">
          MINECRAFT SURVIVAL SERVER
        </p>
    
        <h1 id="hero-title">
          KG SURVIVAL S1
        </h1>
    
        <p class="hero-tagline">
          Explore . Build . Survive
        </p>
    
        <p class="hero-copy">
          Survival Minecraft modern dengan dunia luas,
          progres jangka panjang, dan komunitas yang terus berkembang.
        </p>
    
        <div class="hero-actions">
    
          <a
            class="button button--primary"
            href="#server"
          >
            Server
            <span aria-hidden="true">→</span>
          </a>
    
          <a
            class="button button--ghost"
            href="#community"
          >
            Whatsapp
          </a>
    
        </div>
    
      </div>
    
      <div
        class="hero-scroll"
        aria-hidden="true"
      >
        SCROLL
        <span>↓</span>
      </div>
    </section>


    <!-- About -->

    <section
      class="intro section"
      aria-labelledby="intro-title"
    >

      <div class="container intro-layout">

        <div>

          <p class="eyebrow">
            TENTANG KAMI
          </p>

          <h2 id="intro-title">
            A DIFFERENT KIND<br>
            OF <span>SURVIVAL</span>
          </h2>

          <p class="section-copy">
            KG Survival menghadirkan pengalaman survival Bedrock dengan dunia
            yang terus berkembang, addon menarik, dan berbagai plugin
            custom yang dikembangkan khusus untuk server.
          </p>

        </div>

        <div
          class="intro-art"
          aria-hidden="true"
        >

          <div class="art-orb"></div>

          <div class="art-cube art-cube--one"></div>

          <div class="art-cube art-cube--two"></div>

          <span>
            KGSMP / SURVIVAL
          </span>

        </div>

      </div>


      <div class="container pillars">

        <article class="pillar">
        
          <span class="pillar-number">
            01
          </span>
        
          <h3>
            Survival
          </h3>
        
          <p>
            Gameplay survival yang dirancang untuk progres jangka panjang.
          </p>
        
        </article>
        
        
        <article class="pillar">
        
          <span class="pillar-number">
            02
          </span>
        
          <h3>
            Addons
          </h3>
        
          <p>
            Addon menarik yang menambah variasi dan pengalaman bermain.
          </p>
        
        </article>
        
        
        <article class="pillar">
        
          <span class="pillar-number">
            03
          </span>
        
          <h3>
            Custom Systems
          </h3>
        
          <p>
            Berbagai plugin custom yang dikembangkan khusus untuk KGSMP.
          </p>
        
        </article>

      </div>

    </section>


    <!-- Server -->

    <section
      class="server section"
      id="server"
      aria-labelledby="server-title"
    >

      <div class="container server-card">

        <div>

          <p class="eyebrow">
            SERVER STATUS
          </p>

          <h2 id="server-title">
            THE WORLD IS <span>ALIVE</span>
          </h2>

          <p class="section-copy">
            Bergabunglah dengan pemain lainnya dan rasakan
            keseruan KGSMP.
          </p>

        </div>


        <div class="status-panel">
        
          <div class="status-panel-top">
        
            <span
              class="status-dot"
              aria-hidden="true"
            ></span>
        
            <span data-server-state>
              CHECKING
            </span>
        
          </div>
        
        
          <strong class="server-players">
            <span data-player-count>0</span>
            <span class="server-players-separator" aria-hidden="true">/</span>
            <span data-player-max>0</span>
          </strong>
        
          <span class="server-players-label">
            PLAYERS ONLINE
          </span>
          
          <div class="server-meta">
            <div class="server-meta-item">
              <span>VERSION</span>
              <strong data-server-version>—</strong>
            </div>
          
            <div class="server-meta-item">
              <span>MOTD</span>
              <strong data-server-motd>—</strong>
            </div>
          </div>
        
          <div class="server-ip">
        
            <code data-server-ip>—</code>
        
            <button
              class="copy-button"
              type="button"
              data-copy-ip
              aria-label="Copy server IP"
            >
              Copy IP
            </button>
        
          </div>


  <span
    class="copy-feedback"
    data-copy-feedback
    aria-live="polite"
  ></span>

</div>

      </div>

    </section>
    
    
    <!-- Live Server Chat -->

    <section
      class="live-chat section"
      id="live-chat"
      aria-labelledby="live-chat-title"
    >
      <div class="container live-chat-layout">
    
        <div class="live-chat-content">
    
          <p class="eyebrow">
            LIVE SERVER CHAT
          </p>
    
          <h2 id="live-chat-title">
            OBROLAN <span>SERVER</span>
          </h2>
    
          <p class="section-copy">
            Lihat percakapan pemain yang sedang bermain
            langsung di server KGSMP.
          </p>
    
        </div>
    
    
        <div class="live-chat-panel">
    
          <div class="live-chat-header">
    
            <div class="live-chat-status">
    
              <span
                class="status-dot"
                aria-hidden="true"
              ></span>
    
              <span data-chat-status>
                TERHUBUNG
              </span>
    
            </div>
    
            <span>
              LIVE
            </span>
    
          </div>
    
    
          <div
            class="live-chat-messages"
            data-chat-messages
            aria-live="polite"
            aria-label="Obrolan pemain server"
          >
    
            <p
              class="live-chat-empty"
              data-chat-empty
            >
              Belum ada percakapan.
            </p>
    
          </div>
    
    
          <div class="live-chat-note">
    
            <strong>
              Ingin ikut ngobrol?
            </strong>
    
            <p>
              Bergabung dengan grup WhatsApp KGSMP
              untuk berinteraksi langsung dengan komunitas
              dan pemain yang sedang bermain.
            </p>
    
            <a
              class="button button--primary"
              href="#community"
            >
              Gabung WhatsApp
              <span aria-hidden="true">→</span>
            </a>
    
          </div>
    
        </div>
    
      </div>
    </section>


    <!-- Gameplay Showcase -->

    <section
      class="showcase section"
      aria-labelledby="showcase-title"
    >

      <div class="container">

        <div class="showcase-heading">

          <div>

            <p class="eyebrow">
              GAMEPLAY SHOWCASE
            </p>

            <h2 id="showcase-title">
              EXPLORE A WORLD<br>
              MADE TO BE <span>DISCOVERED</span>
            </h2>

          </div>

          <p class="section-copy">
            Jelajahi dunia survival yang diperkaya dengan
            addon menarik dan sistem custom yang membuat
            pengalaman bermain KGSMP terasa berbeda.
          </p>

        </div>

        <div
          class="showcase-grid showcase-posts"
          data-showcase-posts
        >
          <p class="showcase-loading">
            Memuat gameplay komunitas...
          </p>
        </div>
        
        <div class="showcase-submit">
          <a
            class="button button--primary"
            href="showcase.php"
          >
            Share Your Gameplay
            <span aria-hidden="true">→</span>
          </a>
        </div>

      </div>

    </section>


    <!-- Features -->

    <section
      class="features section"
      id="features"
      aria-labelledby="features-title"
    >

      <div class="container">

        <div class="section-heading">

          <div>

            <p class="eyebrow">
              FITUR UTAMA
            </p>

            <h2 id="features-title">
              BUILT FOR THE <span>LONG RUN</span>
            </h2>

          </div>

          <p class="section-copy">
            Semua yang kamu butuhkan untuk pengalaman
            survival terbaik.
          </p>

        </div>


        <div class="feature-list">
        
          <article class="feature-card">
            <span>01</span>
        
            <h3>Survival</h3>
        
            <p>
              Pengalaman survival klasik dengan gameplay yang
              tetap nyaman untuk dimainkan dalam jangka panjang.
            </p>
          </article>
        
        
          <article class="feature-card">
            <span>02</span>
        
            <h3>Economy</h3>
        
            <p>
              Bangun progres ekonomimu melalui aktivitas,
              perdagangan, dan sistem ekonomi server.
            </p>
          </article>
        
        
          <article class="feature-card">
            <span>03</span>
        
            <h3>Community</h3>
        
            <p>
              Bermain bersama komunitas, membangun proyek,
              dan menciptakan cerita sendiri.
            </p>
          </article>
        
        
          <article class="feature-card">
            <span>04</span>
        
            <h3>Events</h3>
        
            <p>
              Ikuti berbagai aktivitas dan event yang membuat
              dunia KGSMP tetap aktif.
            </p>
          </article>
        
        </div>

      </div>

    </section>


    <!-- Community -->

    <section
      class="community section"
      id="community"
      aria-labelledby="community-title"
    >
      <div class="container community-inner">
    
        <div>
          <p class="eyebrow">
            KOMUNITAS
          </p>
    
          <h2 id="community-title">
            PLAY <span>TOGETHER</span>
          </h2>
    
          <p>
            Bangun, bermain, dan berkembang bersama komunitas KGSMP.
          </p>
        </div>
    
        <a
          class="button button--primary"
          href="ISI_LINK_WHATSAPP_GROUP_KAMU"
          target="_blank"
          rel="noopener noreferrer"
          aria-label="Join KGSMP Whatsapp Group"
        >
          Whatsapp Group
          <span aria-hidden="true">→</span>
        </a>
    
      </div>
    </section>


    <!-- FAQ -->

    <section
      class="faq section"
      id="faq"
      aria-labelledby="faq-title"
    >

      <div class="container faq-layout">

        <div>

          <p class="eyebrow">
            FAQ
          </p>

          <h2 id="faq-title">
            FREQUENTLY ASKED
            <span>QUESTIONS</span>
          </h2>

          <p class="section-copy">
            Jawaban singkat untuk pertanyaan umum tentang
            KGSMP, versi Minecraft, dan cara bergabung.
          </p>

        </div>


        <div class="faq-list" data-faq>

          <details>

            <summary>
              Versi Minecraft apa yang didukung?
              <span aria-hidden="true">+</span>
            </summary>

            <p>
              KGSMP mendukung versi Minecraft yang sedang
              digunakan oleh server. Versi yang aktif ditampilkan
              secara otomatis pada Server Status berdasarkan
              informasi server terbaru.
            </p>

          </details>


          <details>

            <summary>
              KGSMP menggunakan Java Edition atau Bedrock Edition?
              <span aria-hidden="true">+</span>
            </summary>

            <p>
              KGSMP adalah server khusus Minecraft: Bedrock Edition.
              Server ini tidak ditujukan untuk Minecraft: Java Edition.
            </p>

          </details>


          <details>

            <summary>
              Bagaimana cara bergabung ke KGSMP?
              <span aria-hidden="true">+</span>
            </summary>

            <p>
              Buka Minecraft: Bedrock Edition, pilih Play lalu
              Add Server. Masukkan alamat server dan port yang
              ditampilkan pada bagian Server Status di website ini.
            </p>

          </details>


          <details>

            <summary>
              Apakah server selalu online?
              <span aria-hidden="true">+</span>
            </summary>

            <p>
              Server Status menampilkan kondisi server berdasarkan
              pemeriksaan server terbaru. Jika server tidak dapat
              dijangkau, status akan ditampilkan sebagai offline.
            </p>

          </details>


          <details>

            <summary>
              Apakah saya perlu memasang addon?
              <span aria-hidden="true">+</span>
            </summary>

            <p>
              Tidak selalu. Jika sebuah addon diperlukan untuk
              fitur tertentu, informasi dan instruksi pemasangannya
              akan diberikan oleh KGSMP.
            </p>

          </details>


          <details>

            <summary>
              Apakah KGSMP memiliki komunitas?
              <span aria-hidden="true">+</span>
            </summary>

            <p>
              Ya. Kamu dapat bergabung dengan komunitas WhatsApp
              KGSMP untuk mendapatkan informasi terbaru,
              berinteraksi dengan pemain lain, dan mengikuti
              aktivitas server.
            </p>

          </details>


          <details>

            <summary>
              Apakah progress pemain akan tetap tersimpan?
              <span aria-hidden="true">+</span>
            </summary>

            <p>
              KGSMP dirancang sebagai server survival dengan
              progres jangka panjang. Perkembangan pemain dan
              dunia server dipertahankan selama server berjalan.
            </p>

          </details>


          <details>

            <summary>
              Bagaimana jika saya mengalami masalah saat bermain?
              <span aria-hidden="true">+</span>
            </summary>

            <p>
              Hubungi komunitas KGSMP melalui WhatsApp dan
              jelaskan masalah yang kamu alami. Sertakan
              informasi yang relevan agar proses bantuan
              dan troubleshooting dapat dilakukan dengan lebih cepat.
            </p>

          </details>

        </div>

      </div>

    </section>

  </main>


  <!-- Footer -->

  <footer class="site-footer">

    <div class="container footer-grid">

      <div>

        <a
          class="brand"
          href="#top"
          aria-label="KGSMP Home"
        >
          <img
            class="brand-logo"
            src="assets/images/icon.webp"
            alt="KGSMP"
          >

          <span>
            Survival S1
          </span>
        </a>

        <p>
          Minecraft Survival Server
        </p>

      </div>


      <div>

        <strong>
          SERVER
        </strong>

        <span>
          survival.kgsmp.my.id
        </span>

      </div>


      <div>

        <strong>
          COMMUNITY
        </strong>
        
        <span>
          Whatsapp Group
        </span>

      </div>


      <div>

        <span>
          © 2026 KGSMP
        </span>

        <small>
          Not affiliated with Mojang or Microsoft.
        </small>

      </div>

    </div>

  </footer>


  <script
    type="module"
    src="assets/js/main.js"
  ></script>

</body>
</html>