/* ═══════════════════════════════════════════════════
   NABILA HULWANA — PORTFOLIO SCRIPT
═══════════════════════════════════════════════════ */

/* ── NAV SCROLL ── */
window.addEventListener('scroll', () => {
  const nav = document.getElementById('navbar');
  if (window.scrollY > 50) nav.classList.add('scrolled');
  else nav.classList.remove('scrolled');
});

/* ── NAV ACTIVE LINK ── */
const sections = ['profile','experiences','projects','certificates','contact'];
const navLinks = document.querySelectorAll('.nav-link');
window.addEventListener('scroll', () => {
  let current = '';
  sections.forEach(id => {
    const el = document.getElementById(id);
    if (el && window.scrollY >= el.offsetTop - 120) current = id;
  });
  navLinks.forEach(a => {
    a.classList.toggle('active', a.dataset.section === current);
  });
});

/* ═══════════════════════════════════════════════════
   EXPERIENCE SLIDER
═══════════════════════════════════════════════════ */
const expState = {};
function slideExp(id, dir) {
  const wrap = document.getElementById('sl-' + id);
  const slides = wrap.querySelector('.exp-slides');
  const imgs = slides.querySelectorAll('img');
  if (!expState[id]) expState[id] = 0;
  expState[id] = (expState[id] + dir + imgs.length) % imgs.length;
  slides.style.transform = `translateX(-${expState[id] * 100}%)`;
}

/* ═══════════════════════════════════════════════════
   PROJECT DATA
═══════════════════════════════════════════════════ */
const projects = {

  p1: {
    title: 'FHV Vehicle Trip in NYC Analysis & Prediction',
    cat: 'Data Analysis',
    catFilter: 'data',
    desc: `Data berasal dari New York City Taxi and Limousine Commission (TLC). Sumber Data: Website resmi NYC.gov.\n\n<b>Tujuan Bisnis:</b> Mengoptimalkan alokasi pengemudi dan strategi penetapan harga untuk meningkatkan efisiensi operasional layanan FHV (Uber & Lyft) yang melayani lebih dari 600 ribu perjalanan per hari.\n\n<b>Fokus:</b>\n1. Pembersihan dan analisis data menggunakan SQL & Python\n2. Membangun model Machine Learning untuk prediksi durasi perjalanan\n3. Membuat dashboard interaktif Tableau untuk analisis perbandingan layanan Uber & Lyft\n4. Prediksi perjalanan, analisis jam sibuk, rata-rata bayaran pengemudi, volume pesanan per hari, distribusi zona pengantaran dan penjemputan\n5. Insight utama: jam sibuk, zona tersibuk, dan alokasi driver`,
    tech: ['Python','SQL','Tableau'],
    links: [
      { label: 'PPT', icon: 'fas fa-file-powerpoint', url: 'https://drive.google.com/file/d/1p9wDmf0Gp6D4YEnL0laxI8uhOPwShsfV/view?usp=sharing' },
      { label: 'Kaggle', icon: 'fas fa-code', url: 'https://www.kaggle.com/code/nabilahulwana/analysis-data-of-fhv-lisence-in-nyc' },
    ],
    media: [
      { type: 'img', src: 'myprojects/taxianalysis/taxi1.png' },
      { type: 'img', src: 'myprojects/taxianalysis/taxi2.png' },
      { type: 'img', src: 'myprojects/taxianalysis/taxi3.png' },
      { type: 'img', src: 'myprojects/taxianalysis/taxi4.png' },
      { type: 'img', src: 'myprojects/taxianalysis/taxi5.png' },
      { type: 'img', src: 'myprojects/taxianalysis/taxi6.png' },
      { type: 'img', src: 'myprojects/taxianalysis/taxi7.png' },
      { type: 'img', src: 'myprojects/taxianalysis/taxi8.png' },
      { type: 'pdf', src: 'myprojects/taxianalysis/ppttaxi.pdf', label: 'Download PPT PDF' },
    ]
  },

  p2: {
    title: 'HR Attrition Analysis',
    cat: 'Data Analysis',
    catFilter: 'data',
    desc: `<b>Tujuan:</b> Mengidentifikasi faktor utama penyebab tingginya attrition (resign).\n\n<b>Metodologi Analisis:</b>\n• Menggunakan dataset IBM HR Analytics dari Kaggle (1470 data karyawan)\n• Data cleaning, handling missing values & duplicate data, serta feature engineering menggunakan Python (Pandas)\n• Analisis statistik dan visualisasi data menggunakan Pandas, Seaborn, Matplotlib, dan Excel\n• Membuat dashboard interaktif menggunakan Power BI untuk insight operasional\n\n<b>Insight Utama:</b>\n• Pendapatan Rendah: 55% attrition berasal dari karyawan dengan gaji < $2.000\n• Kelompok Usia Muda: Usia 18–26 tahun memiliki tingkat resign tertinggi\n• Job Role & Masa Kerja: Posisi entry-level seperti Sales Executive dan Lab Technician memiliki turnover tinggi\n• Work-Life Balance: Skor WLB dan Environment Satisfaction rendah menjadi faktor kuat resign\n• Status Pernikahan: Karyawan dengan status single memiliki risiko resign lebih tinggi`,
    tech: ['Python','SQL','Power BI','Excel','GitHub'],
    links: [
      { label: 'PPT', icon: 'fas fa-file-powerpoint', url: 'https://drive.google.com/file/d/1lrkkQ0Os66MAdBX2xEvuluNdFhYn3v1Q/view?usp=sharing' },
      { label: 'Kaggle', icon: 'fas fa-code', url: 'https://www.kaggle.com/code/nabilahulwana/hr-analytics-a-case-study-on-employee-attrition' },
      { label: 'Power BI Dashboard', icon: 'fas fa-chart-bar', url: 'https://drive.google.com/file/d/1EXKROfxeIs3ftUMMWxpANOcGnSTekh0J/view?usp=sharing' },
    ],
    media: [
      { type: 'img', src: 'myprojects/hranalisis/hr1.png' },
      { type: 'img', src: 'myprojects/hranalisis/hr2.png' },
      { type: 'img', src: 'myprojects/hranalisis/hr3.png' },
      { type: 'img', src: 'myprojects/hranalisis/hr4.png' },
      { type: 'img', src: 'myprojects/hranalisis/hr5.png' },
      { type: 'img', src: 'myprojects/hranalisis/hr6.png' },
      { type: 'img', src: 'myprojects/hranalisis/hr7.png' },
      { type: 'img', src: 'myprojects/hranalisis/hr8.png' },
      { type: 'img', src: 'myprojects/hranalisis/hr9.png' },
      { type: 'img', src: 'myprojects/hranalisis/hr10.png' },
      { type: 'pdf', src: 'myprojects/hranalisis/PPT - HR Attrition Analysis.pdf', label: 'Download PPT PDF' },
    ]
  },

  p3: {
    title: 'Optimization of Airbnb LA Analysis with AI Agent IBM Granite',
    cat: 'Data Analysis · AI',
    catFilter: 'data',
    desc: `Analisis Kuantitatif & Kualitatif Properti Airbnb Los Angeles (Juni 2025) untuk menentukan strategi harga dan keunggulan airbnb dan klasifikasi berbasis AI.\n\n<b>Data:</b> 32.442 listing Airbnb Los Angeles (79 kolom data)\n\n<b>Proses Analisis:</b>\n• Melakukan data cleaning dan normalisasi harga serta handling missing values\n• Analisis EDA dan query data menggunakan Pandas Agent\n• Menggunakan IBM Granite untuk klasifikasi AI berbasis deskripsi listing:\n  — Tipe tamu (Solo, Family, Business)\n  — Tipe host (Elite/Superhost, Professional)\n  — Tipe aturan pemesanan (Strict/Flexible)\n• Visualisasi analisis profit, demand, distribusi harga, dan revenue room type\n\n<b>Insight Utama:</b>\n• Segmentasi pasar antara area premium (Bel-Air, Malibu) dan area volume tinggi\n• 50% harga listing berada pada rentang kompetitif $107–$228 per malam\n• Host berkualitas tinggi (Superhost, respons 100%) memiliki okupansi tertinggi\n• Listing dengan kategori AI "Business" atau "Couple" dapat memasang harga di atas rata-rata pasar`,
    tech: ['IBM Granite','LangChain','Python','Pandas'],
    links: [
      { label: 'Kaggle', icon: 'fas fa-code', url: 'https://www.kaggle.com/code/nabilahulwana/analysis-of-airbnb-la-using-ibm-granite' },
      { label: 'PPT', icon: 'fas fa-file-powerpoint', url: 'https://drive.google.com/file/d/13Zp7343i7t8R-1_VAbd9B-yCR3h-2VTF/view?usp=sharing' },
    ],
    media: [
      { type: 'img', src: 'myprojects/airbnb/airbnb1.png' },
      { type: 'img', src: 'myprojects/airbnb/airbnb2.png' },
      { type: 'img', src: 'myprojects/airbnb/airbnb3.png' },
      { type: 'img', src: 'myprojects/airbnb/airbnb4.png' },
      { type: 'img', src: 'myprojects/airbnb/airbnb5.png' },
      { type: 'pdf', src: 'myprojects/airbnb/PPT-AIRBNB-IBM-GRANITE.pdf', label: 'Download PPT PDF' },
    ]
  },

  p4: {
    title: 'DQFashion Sales Analysis 2017 : Transaction & Revenue',
    cat: 'Data Analysis',
    catFilter: 'data',
    desc: `<b>Tujuan Proyek:</b> Menganalisis pola penjualan, performa cabang, dan kategori produk untuk membantu penyusunan strategi bisnis berbasis data.\n\n<b>Data:</b> 118 ribu+ transaksi penjualan dari 4 cabang di Indonesia\n<b>Tools:</b> Power Query, Power Pivot, PivotTable, Dashboard Excel\n\n<b>Insight Utama:</b>\n• Total revenue tahun 2017 mencapai Rp 59,9 Miliar dari 396 transaksi dan 236 ribu produk terjual\n• Puncak penjualan terjadi pada bulan Juni akibat momentum Idul Fitri, sedangkan Februari menjadi bulan terendah\n• Kategori Gaun/Dress memberikan revenue tertinggi, sementara aksesoris memiliki volume tinggi tetapi revenue rendah\n• Cabang Jakarta unggul dalam jumlah transaksi, sedangkan Medan memiliki nilai transaksi terbesar\n• Pola penjualan menunjukkan peningkatan signifikan saat weekend, terutama hari Minggu\n\n<b>Target Bisnis:</b> Proyeksi peningkatan revenue tahun 2018 dari Rp 59,9 M menjadi Rp 73 Miliar (+22%) melalui strategi promosi, bundling, dan optimasi cabang.`,
    tech: ['Excel','Power Query','Power Pivot','DAX'],
    links: [
      { label: 'Dashboard Excel', icon: 'fas fa-file-excel', url: 'https://docs.google.com/spreadsheets/d/17QrRXMXzql1refVmZ3UsJkgw5d6Khfwq/edit?usp=sharing' },
      { label: 'PPT', icon: 'fas fa-file-powerpoint', url: 'https://drive.google.com/file/d/1pDiMcr2Yc9nKKiCqYnEa4iluJCrhpHTg/view?usp=sharing' },
    ],
    media: [
      { type: 'img', src: 'myprojects/exceldqlab/transaksi.png' },
      { type: 'img', src: 'myprojects/exceldqlab/finance.png' },
      { type: 'pdf', src: 'myprojects/exceldqlab/pptDQLabFashion2017Analysis.pdf', label: 'Download PPT PDF' },
      { type: 'pdf', src: 'myprojects/exceldqlab/sertifikat1.pdf', label: 'Download Sertifikat 1' },
      { type: 'pdf', src: 'myprojects/exceldqlab/sertifikat2.pdf', label: 'Download Sertifikat 2' },
    ]
  },

  p5: {
    title: 'Python Hackathon: DQLab Retail Crisis & Recovery',
    cat: 'Data Analysis · Hackathon',
    catFilter: 'data',
    desc: `<b>Project:</b> Automated Sales Pipeline & Market Basket Analysis\n<b>Tools:</b> Python (Pandas, Mlxtend, Matplotlib), Openpyxl\n<b>Data:</b> Transaksi retail 6 bulan terakhir (DQFresh Mart)\n\n<b>Tujuan Proyek:</b> Membalikkan tren penurunan penjualan 6 bulan terakhir dengan mendeteksi produk kecil yang tumbuh konsisten (Rising Star) dan menentukan strategi bundling.\n\n<b>Pipeline & Metodologi:</b>\n• Deteksi Rising Star: Menggunakan Moving Average 3 hari. Produk difilter jika mengalami tren kenaikan berurutan > 12 hari, lalu dihitung Growth % dan dinormalisasi ke Base 100\n• Potential Packaging: Menggunakan Algoritma Apriori (Association Rules) pada basket matrix transaksi dengan parameter min_support 1%, Lift > 2, dan minimal salah satu itemnya adalah produk Rising Star\n\n<b>Output:</b>\n• retail_insight.xlsx: File Excel dengan 2 sheet — daftar lengkap Rising Star dan rekomendasi Potential Packaging\n• rising_star_index.png: Line chart pertumbuhan relatif (Base 100)\n• rising_star_actual.png: Line chart nilai penjualan asli`,
    tech: ['Python','Pandas','Mlxtend','Openpyxl','Matplotlib'],
    links: [
      { label: 'GitHub', icon: 'fab fa-github', url: 'https://github.com/nabilahlw/DQLabHackathon-RetailCrisisRecovery.git' },
      { label: 'LinkedIn Post', icon: 'fab fa-linkedin', url: 'https://www.linkedin.com/posts/nabila-hulwana_dqlab-python-hackathon-ugcPost-7467843472805236737-F7gN/' },
    ],
    media: [
      { type: 'img', src: 'myprojects/hackathondqlab/index.png' },
      { type: 'img', src: 'myprojects/hackathondqlab/actual.png' },
      { type: 'pdf', src: 'myprojects/hackathondqlab/PPT - Hackathon DQLab.pdf', label: 'Download PPT PDF' },
      { type: 'pdf', src: 'myprojects/hackathondqlab/SOAL-HACKATHON.pdf', label: 'Download Soal Hackathon' },
    ]
  },

  p6: {
    title: 'TMDB Movie End-to-End Data Pipeline (Bronze → Silver → Gold → Dashboard & Cloud)',
    cat: 'Data Engineering',
    catFilter: 'engineering',
    desc: `<b>Proses Pipeline:</b>\n• Mengambil data dari TMDB API dan dataset Kaggle (movies & credits)\n• Ingestion & Orchestration: Apache Airflow mengotomatisasi 5 tugas sekuensial setiap hari Senin\n• Medallion Architecture (PostgreSQL & dbt):\n  — Bronze: Raw ingestion dari API dan CSV\n  — Silver & Gold: Transformasi data 14 dbt models untuk staging hingga menjadi Business Ready Data Mart\n• Distributed Processing: Menggunakan PySpark ETL untuk ekstraksi skema JSON, pembersihan data, dan pelabelan performa secara terdistribusi\n• Data Streaming: Menggunakan Kafka + Debezium CDC via PostgreSQL WAL\n• Hybrid Storage & OLAP: Data Lake (7 file Parquet) di MinIO S3-Compatible, BigQuery (Cloud Data Warehouse), dan ClickHouse OLAP\n• Data Visualization: Dashboard interaktif dengan Streamlit\n\n<b>Insight & Fitur Utama:</b>\n• Analisis tren revenue dan profit industri film tahun 1992–2016\n• Identifikasi genre paling profitable dan sutradara dengan ROI tertinggi\n• Klasifikasi performa film: Mega Blockbuster, Blockbuster, Profitable, hingga Loss\n• Optimasi query menggunakan indexing, partitioning, dan materialized views`,
    tech: ['PostgreSQL','PySpark','dbt','Kafka','ClickHouse','MinIO','Streamlit','Airflow','BigQuery'],
    links: [
      { label: 'GitHub', icon: 'fab fa-github', url: 'https://github.com/nabilahlw/tmdb-pipeline-project.git' },
      { label: 'PPT', icon: 'fas fa-file-powerpoint', url: 'https://drive.google.com/file/d/1qMtpFDz7-v6o20gDUy6q3oLnVrdvzOSk/view?usp=sharing' },
    ],
    media: [
      { type: 'img', src: 'myprojects/tmdbpipeline/arsitekturtmdb.png' },
      { type: 'pdf', src: 'myprojects/tmdbpipeline/ppttmdb.pdf', label: 'Download PPT PDF' },
      { type: 'pdf', src: 'myprojects/tmdbpipeline/dokumentasitmdb.pdf', label: 'Download Dokumentasi' },
    ]
  },

  p7: {
    title: 'FINOTE - Digital Wallet App',
    cat: 'Mobile Development',
    catFilter: 'app',
    desc: `<b>Tujuan Aplikasi:</b> Pencatatan keuangan pribadi berbasis Flutter dan Firebase yang membantu pengguna mencatat pemasukan dan memantau kondisi keuangan harian dengan pencatatan transaksi yang sederhana, aman, dan mudah digunakan.\n\n<b>Fitur Utama:</b>\n• Sistem login & registrasi aman menggunakan Firebase Authentication\n• CRUD transaksi pemasukan dan pengeluaran\n• Riwayat transaksi tersusun rapi dan mudah dipantau\n• Dikembangkan menggunakan konsep OOP untuk kode yang lebih rapi dan scalable\n\n<b>Tools & Teknologi:</b>\n• Flutter (Frontend & UI Framework)\n• Firebase: Authentication, Cloud Firestore, Realtime Database\n• Android Studio`,
    tech: ['Flutter','Firebase','Dart','Android Studio'],
    links: [
      { label: 'GitHub', icon: 'fab fa-github', url: 'https://github.com/nabilahlw/finote.git' },
    ],
    media: [
      { type: 'img', src: 'myprojects/finote/finote1.png' },
      { type: 'img', src: 'myprojects/finote/finote2.png' },
      { type: 'img', src: 'myprojects/finote/finote3.png' },
      { type: 'img', src: 'myprojects/finote/finote4.png' },
      { type: 'img', src: 'myprojects/finote/finote5.png' },
      { type: 'img', src: 'myprojects/finote/finote6.png' },
    ]
  },

  p8: {
    title: 'TRAIN IN - Ticketing Website',
    cat: 'Web Development',
    catFilter: 'app',
    desc: `<b>Tujuan Aplikasi:</b> TrainIN adalah sistem e-ticketing kereta api berbasis web yang dikembangkan dengan JavaScript dan PHP. Aplikasi ini memungkinkan user untuk:\n• Mencari jadwal perjalanan dan memilih jenis armada sesuai kebutuhan\n• Input data pemesan serta detail penumpang secara terstruktur\n• Mengunggah bukti pembayaran (jpg/png)\n• Mencetak invoice\n• Seluruh data transaksi tersimpan dan terkelola dengan baik melalui MySQL (phpMyAdmin)\n\n<b>Fitur Utama:</b>\n• Pencarian jadwal dan jenis armada\n• CRUD jadwal keberangkatan dan data penumpang\n• Pembayaran online dan cetak invoice menjadi image\n• Data yang rapi di phpMyAdmin\n\n<b>Tools & Teknologi:</b>\n• Frontend: HTML, CSS, JavaScript\n• Backend: PHP\n• Database: MySQL (phpMyAdmin)`,
    tech: ['PHP','HTML','CSS','JavaScript','MySQL'],
    links: [
      { label: 'GitHub', icon: 'fab fa-github', url: 'https://github.com/nabilahlw/train_in.git' },
      { label: 'Drive Folder', icon: 'fab fa-google-drive', url: 'https://drive.google.com/drive/folders/1j7Zw--s86KhMUaV8FxTHavpYXvEboi8A?usp=drive_link' },
    ],
    media: [
      { type: 'img', src: 'myprojects/keretain/kereta1.png' },
      { type: 'img', src: 'myprojects/keretain/kereta2.png' },
      { type: 'img', src: 'myprojects/keretain/kereta3.png' },
      { type: 'img', src: 'myprojects/keretain/kereta4.png' },
      { type: 'img', src: 'myprojects/keretain/kereta5.png' },
      { type: 'img', src: 'myprojects/keretain/kereta6.png' },
    ]
  }
};

/* ═══════════════════════════════════════════════════
   PROJECT PAGES / PAGINATION
═══════════════════════════════════════════════════ */
let currentPage = 0;
const ITEMS_PER_PAGE = 6;
let activeFilter = 'all';
let filteredKeys = [];

function getFilteredKeys() {
  const all = Object.keys(projects);
  if (activeFilter === 'all') return all;
  return all.filter(k => projects[k].catFilter === activeFilter);
}

function renderProjects() {
  filteredKeys = getFilteredKeys();
  currentPage = 0;

  const totalPages = Math.ceil(filteredKeys.length / ITEMS_PER_PAGE);
  const pagesEl = document.getElementById('projPages');
  const dotsEl  = document.getElementById('projDots');

  let html = '';
  for (let p = 0; p < totalPages; p++) {
    const pageKeys = filteredKeys.slice(p * ITEMS_PER_PAGE, (p + 1) * ITEMS_PER_PAGE);
    html += `<div class="proj-page">`;
    pageKeys.forEach(k => {
      const proj = projects[k];
      const thumb = proj.media.find(m => m.type === 'img');
      const thumbSrc = thumb ? thumb.src : '';
      html += `
        <div class="proj-card" onclick="openModal('${k}')">
          <div class="proj-thumb-wrap">
            <img src="${thumbSrc}" onerror="this.style.display='none'" alt="${proj.title}">
            <div class="proj-title-overlay">${proj.title}</div>
          </div>
          <div class="proj-body">
            <span class="proj-cat-badge">${proj.cat}</span>
            <h3>${proj.title}</h3>
          </div>
        </div>`;
    });
    const empty = ITEMS_PER_PAGE - pageKeys.length;
    for (let e = 0; e < empty; e++) html += `<div></div>`;
    html += `</div>`;
  }
  pagesEl.innerHTML = html;

  let dotsHtml = '';
  for (let i = 0; i < totalPages; i++) {
    dotsHtml += `<button class="proj-dot ${i===0?'active':''}" onclick="goPage(${i})">${i+1}</button>`;
  }
  dotsEl.innerHTML = dotsHtml;

  goPage(0);
}

function goPage(n) {
  currentPage = n;
  const pagesEl = document.getElementById('projPages');
  pagesEl.style.transform = `translateX(-${n * 100}%)`;
  document.querySelectorAll('.proj-dot').forEach((d,i) => d.classList.toggle('active', i===n));
}

document.addEventListener('DOMContentLoaded', () => {
  renderProjects();

  document.querySelectorAll('.filt-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.filt-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeFilter = btn.dataset.filter;
      renderProjects();
    });
  });
});

/* ═══════════════════════════════════════════════════
   PROJECT MODAL
═══════════════════════════════════════════════════ */
let modalSlideIndex = 0;
let currentMediaList = [];

function openModal(id) {
  const proj = projects[id];
  if (!proj) return;

  document.getElementById('mTitle').textContent = proj.title;
  document.getElementById('mCat').textContent = proj.cat;

  document.getElementById('mDesc').innerHTML = proj.desc.replace(/\n/g, '<br>');

  const linksEl = document.getElementById('mLinks');
  linksEl.innerHTML = proj.links.map(l =>
    `<a href="${l.url}" target="_blank"><i class="${l.icon}"></i> ${l.label}</a>`
  ).join('');

  const techEl = document.getElementById('mTech');
  techEl.innerHTML = proj.tech.map(t => `
    <div class="tech-icon">
      <i class="${getTechIcon(t)}"></i>
      <span class="ti-label">${t}</span>
    </div>`).join('');

  currentMediaList = proj.media;
  modalSlideIndex = 0;
  buildModalSlides();

  document.getElementById('modalOverlay').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function buildModalSlides() {
  const slides = document.getElementById('mSlides');
  slides.innerHTML = currentMediaList.map((m, i) => {
    if (m.type === 'img') {
      return `<img src="${m.src}" alt="slide ${i+1}" onerror="this.src='https://placehold.co/600x400/EADEBF/788E77?text=Gambar+${i+1}'">`;
    } else if (m.type === 'pdf') {
      return `
        <div class="pdf-slide">
          <embed src="${m.src}" type="application/pdf" width="100%" height="100%">
          <a class="pdf-download-btn" href="${m.src}" download target="_blank">
            <i class="fas fa-download"></i> ${m.label || 'Download PDF'}
          </a>
        </div>`;
    }
    return '';
  }).join('');
  updateModalSlide();
}

function updateModalSlide() {
  const slides = document.getElementById('mSlides');
  slides.style.transform = `translateX(-${modalSlideIndex * 100}%)`;
  const count = document.getElementById('mCount');
  count.textContent = `${modalSlideIndex + 1} / ${currentMediaList.length}`;
}

function slideModal(dir) {
  modalSlideIndex = (modalSlideIndex + dir + currentMediaList.length) % currentMediaList.length;
  updateModalSlide();
}

function closeModal() {
  document.getElementById('modalOverlay').classList.remove('open');
  document.body.style.overflow = '';
}

function closeModalOutside(e) {
  if (e.target === document.getElementById('modalOverlay')) closeModal();
}

/* ═══════════════════════════════════════════════════
   TECH ICON HELPER
═══════════════════════════════════════════════════ */
function getTechIcon(name) {
  const map = {
    'Python':         'devicon-python-plain colored',
    'SQL':            'devicon-mysql-plain colored',
    'Tableau':        'devicon-tableau-plain colored',
    'Power BI':       'devicon-powerbi-plain colored',
    'Excel':          'fas fa-file-excel',
    'GitHub':         'devicon-github-plain',
    'Flutter':        'devicon-flutter-plain colored',
    'Firebase':       'devicon-firebase-plain colored',
    'Dart':           'devicon-dart-plain colored',
    'PHP':            'devicon-php-plain colored',
    'HTML':           'devicon-html5-plain colored',
    'CSS':            'devicon-css3-plain colored',
    'JavaScript':     'devicon-javascript-plain colored',
    'MySQL':          'devicon-mysql-plain colored',
    'PostgreSQL':     'devicon-postgresql-plain colored',
    'PySpark':        'devicon-apachespark-plain colored',
    'dbt':            'fas fa-layer-group',
    'Kafka':          'fas fa-stream',
    'ClickHouse':     'fas fa-database',
    'MinIO':          'fas fa-archive',
    'Streamlit':      'fas fa-chart-area',
    'Airflow':        'fas fa-wind',
    'BigQuery':       'fab fa-google',
    'Pandas':         'fas fa-table',
    'Matplotlib':     'fas fa-chart-bar',
    'Mlxtend':        'fas fa-project-diagram',
    'Openpyxl':       'fas fa-file-excel',
    'IBM Granite':    'fas fa-brain',
    'LangChain':      'fas fa-link',
    'Power Query':    'fas fa-filter',
    'Power Pivot':    'fas fa-cubes',
    'DAX':            'fas fa-function',
    'Android Studio': 'fab fa-android',
  };
  return map[name] || 'fas fa-code';
}

/* ═══════════════════════════════════════════════════
   CERTIFICATES MODAL
   Uses actual filenames from /certificates/ folder.
   JPG = tampil langsung | PDF = embed + link Drive
═══════════════════════════════════════════════════ */
const CERTS = [
  { title: 'SmartPath Bootcamp — Advanced Tableau: Data Storytelling & Geospatial Visualization',
    file: 'certificates/Certificate - Advanced Tableau - SmartPath.jpg',
    isImg: true,
    dl: 'https://drive.google.com/file/d/1FitDy0euaLKGKZa-jCuEpqRA9xQW-EkA/view?usp=sharing' },

  { title: 'Belajar Dasar Cloud dan Gen AI di AWS — Dicoding',
    file: 'certificates/Certificate - Belajar Dasar Cloud & Gen AI di AWS - Dicoding.pdf',
    isImg: false,
    dl: 'https://drive.google.com/file/d/1RabPLcsYWLCgAHPpBlMymfgVbhZTwc5b/view?usp=sharing' },

  { title: 'Classifying & Summarizing Data Using IBM Granite — IBM SkillsBuild',
    file: 'certificates/Certificate - Classifying Data Using IBM Granite - IBM SkillsBuild.pdf',
    isImg: false,
    dl: 'https://drive.google.com/file/d/11w8fnLLrl1kTyiWylzaSy0zxa56sd0s8/view?usp=sharing' },

  { title: 'SmartPath Bootcamp — Comprehensive SQL Mastery',
    file: 'certificates/Certificate - Comprehensive SQL Mastery - SmartPath.jpg',
    isImg: true,
    dl: 'https://drive.google.com/file/d/1ZsyO_0PwIoGDcXJWfmKA6U9K-EMzfBae/view?usp=sharing' },

  { title: 'Bootcamp Data Analyst — Special Skill Indonesia',
    file: 'certificates/Certificate - Data Analyst Bootcamp - Special Skill.pdf',
    isImg: false,
    dl: 'https://drive.google.com/file/d/13OegvjcMMcwtL4tf86d6A7ok-1oW_AZu/view?usp=sharing' },

  { title: 'Data Engineering Mini Bootcamp Batch 7 — rubythalib.ai',
    file: 'certificates/Certificate - Data Engineering Bootcamp - rubythalib.pdf',
    isImg: false,
    dl: 'https://drive.google.com/file/d/1qPOSrGff845JOT_zNaJUwZGKp4lbfO7z/view?usp=sharing' },

  { title: 'Belajar Penerapan Data Science dengan Microsoft Fabric — Dicoding',
    file: 'certificates/Certificate - Data Science dengan Microsoft Fabric - Dicoding.pdf',
    isImg: false,
    dl: 'https://drive.google.com/file/d/1VbzMMW02c1rI98VttQri2od3dx-a4RNg/view?usp=sharing' },

  { title: 'Data Summarization & Classification Using IBM Granite — IBM SkillsBuild',
    file: 'certificates/Certificate - DataSummmarization&Classification - IBM SkillsBuild.pdf',
    isImg: false,
    dl: 'https://drive.google.com/file/d/1edbxx5RtR6Uvh0_kYVHwAmDOEhQsXz9G/view?usp=sharing' },

  { title: 'EF SET English Certificate — B2 Upper Intermediate (60/100)',
    file: 'certificates/Certificate - EF SET English Certificate B2.pdf',
    isImg: false,
    dl: 'https://drive.google.com/file/d/1f7E_acxqKdw6Tq3w-cQi1PhMk3hVgokw/view?usp=sharing' },

  { title: 'International Business Seminar — Excel Mastery for Professionals',
    file: 'certificates/Certificate - Excel Mastery for Professionals - Business Education.pdf',
    isImg: false,
    dl: 'https://drive.google.com/file/d/1MkYsEPOXgGMHZQzHnge4e2OFCjq1C1v9/view?usp=sharing' },

  { title: 'SmartPath Bootcamp — Excel Proficiency to Business Strategy',
    file: 'certificates/Certificate - Excel Proficiency to Business Strategy - SmartPath.jpg',
    isImg: true,
    dl: 'https://drive.google.com/file/d/1IAdUKlO00ZTeQ5-MqCzuGxm9wDEQYOEO/view?usp=sharing' },

  { title: 'Introduction to Data Engineering — IBM / Coursera',
    file: 'certificates/Certificate - IntroTo Data Engineering - IBM Coursera.pdf',
    isImg: false,
    dl: 'https://drive.google.com/file/d/1VnTyRk_yrVM0mzvcm0N0MRAUAQgoErei/view?usp=sharing' },

  { title: 'Preparing Data for Analysis with Microsoft Excel — Coursera',
    file: 'certificates/Certificate - Preparing Data for Analysis with Excel - Coursera.pdf',
    isImg: false,
    dl: 'https://drive.google.com/file/d/10uPr3--f5sYse-UQfeIQdJCVnC7lZorC/view?usp=sharing' },

  { title: 'Peserta Workshop StartUp Digital Open Source — Fikom UDB',
    file: 'certificates/Certificate - StartUp Digital Open Source - Fikom UDB.jpg',
    isImg: true,
    dl: 'https://drive.google.com/file/d/1lfbt5-Rfq6tfjHMaC_had0-l99UxfkCj/view?usp=sharing' },

  { title: 'Certificate of Achievement — Hackathon Retail Crisis & Recovery (Top 100, Rank #88/464)',
    file: 'certificates/certificate of Achievement - Hackaton Retail Crisis & R...very Visualization Challenge using Python - DQLab.pdf',
    isImg: false,
    dl: 'https://drive.google.com/file/d/1_bxGeNfbSish9Lcyj2MtboVZfk_9SuXj/view?usp=sharing' },

  { title: 'Bootcamp Data Analyst with Excel Batch 22 — DQLab (Sertifikat Kelulusan)',
    file: 'certificates/Certificate of Completion - Bootcamp Data Analyst with Excel Batch 22 - DQLab.pdf',
    isImg: false,
    dl: 'https://drive.google.com/file/d/12vdkBmxI0Lu3afrMpXmsfy9O4aETUihw/view?usp=sharing' },

  { title: 'Student Transcript — Data Classification & Summarization (IBM SkillsBuild x Hacktiv8)',
    file: 'certificates/Student Transkip - Data Classification & Summarization Using IBM Granite - Hacktiv8 & IBM SkillsBuild.pdf',
    isImg: false,
    dl: 'https://drive.google.com/file/d/1VbzMMW02c1rI98VttQri2od3dx-a4RNg/view?usp=sharing' },
];

/* openCert now called directly from onclick with (title, previewUrl, downloadUrl) */
function openCert(title, previewUrl, downloadUrl) {
  // Set header title
  document.getElementById('certModalTitle').textContent = title;

  // Set download button
  const dl = document.getElementById('certModalDl');
  dl.href = downloadUrl;

  // Build body: Google Drive iframe embed
  const body = document.getElementById('certModalBody');
  body.innerHTML = `
    <iframe
      src="${previewUrl}"
      style="width:100%; height:72vh; border:none; border-radius:8px;"
      allow="autoplay"
      loading="lazy">
    </iframe>`;

  document.getElementById('certModalOverlay').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeCert() {
  document.getElementById('certModalOverlay').classList.remove('open');
  // Clear iframe to stop loading
  document.getElementById('certModalBody').innerHTML = '';
  document.body.style.overflow = '';
}

function closeCertOutside(e) {
  if (e.target === document.getElementById('certModalOverlay')) closeCert();
}

/* ── Global Escape Key ── */
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') { closeModal(); closeCert(); }
  if (document.getElementById('modalOverlay').classList.contains('open')) {
    if (e.key === 'ArrowRight') slideModal(1);
    if (e.key === 'ArrowLeft')  slideModal(-1);
  }
});