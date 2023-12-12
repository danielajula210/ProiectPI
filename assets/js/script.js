import ProductCard from "./ProductCard.js";
import TrendingCard from "./TrendingCard.js";

const navBar = document.querySelector(".header"),
    navBtn = document.querySelector(".header__btn"),
    sections = document.querySelectorAll("section[id]"),
    newContent = document.querySelector(".new__products"),
    shopContent = document.querySelector(".shop__products"),
    trendingContent = document.querySelector(".trending__products"),
    shopCategories = document.querySelectorAll(".shop__category"),
    circleBtn = document.querySelector(".go-down-btn"),
    scrollUpBtn = document.querySelector(".scroll-up");

const API_URL = "../assets/apis/products.json";


// initialize Scroll Reveal
const sr = ScrollReveal({ origin: "top", distance: "100px", duration: 2000, delay: 300 });

/*===========Dark Mode============*/
document.addEventListener("DOMContentLoaded", function () {
    const darkModeToggleBtn = document.getElementById("dark-mode-toggle");
    const body = document.body;

    // Check if the user has a preferred color scheme
    const prefersDarkMode = window.matchMedia("(prefers-color-scheme: dark)").matches;

    // Set initial dark mode based on user preference
    if (prefersDarkMode) {
        body.classList.add("dark-mode");
    }

    darkModeToggleBtn.addEventListener("click", function () {
        // Toggle the 'dark-mode' class on the body
        body.classList.toggle("dark-mode");

        // Check if dark mode is now enabled
        const isDarkMode = body.classList.contains("dark-mode");

        // Update the button text and icon based on the dark mode state
        if (isDarkMode) {
            darkModeToggleBtn.innerHTML = '<span class="material-symbols-rounded">brightness_7</span>';
        } else {
            darkModeToggleBtn.innerHTML = '<span class="material-symbols-rounded">brightness_4</span>';
        }
    });
});




/*const darkModeToggleBtn = document.querySelector('.dark-mode-toggle-btn');
const body = document.body;

darkModeToggleBtn.addEventListener('click', () => {
    // Toggle the 'dark-mode' class first
    body.classList.toggle('dark-mode');

    // Check if the body has the 'dark-mode' class after toggling
    const isDarkMode = body.classList.contains('dark-mode');

    // Set button text and styles based on the mode
    if (isDarkMode) {
        darkModeToggleBtn.textContent = 'Dark Mode';
        darkModeToggleBtn.style.backgroundColor = 'var(--bg-color)';
        darkModeToggleBtn.style.color = 'var(--text-color)';
    } else {
        darkModeToggleBtn.textContent = 'Light Mode';
        darkModeToggleBtn.style.backgroundColor = 'var(--text-color)';
        darkModeToggleBtn.style.color = 'var(--bg-color)';
    }
});*/




/* ============== Header ============== */

navBtn.addEventListener("click", () => document.body.classList.toggle("menu-toggled"));

function changeHeaderBg() {
    const scrollY = window.scrollY;
    if (scrollY > 100) {
        navBar.style.backgroundColor = "var(--white-100-opcty-212)";
    } else {
        navBar.style.backgroundColor = "transparent";
    }
}

/* ============== Home Section ============== */

/* Swiper JS */

const homeSwiper = new Swiper(".home__content", {
    loop: true,
    effect: "fade",
    speed: 2000,
    allowTouchMove: false,
    autoplay: {
        delay: 6000,
        disableOnInteraction: false,
    },
});

homeSwiper.on("slideChange", () => {
    const activeSlide = homeSwiper.slides[homeSwiper.activeIndex];
    activeSlide.classList.add("reveal");
});

homeSwiper.on("slideChangeTransitionEnd", () => {
    const prevSlide = homeSwiper.slides[homeSwiper.previousIndex];
    prevSlide.classList.remove("reveal");
});

/* Circle Btn */

let circleText = circleBtn.querySelector(".circle-text");
circleText.innerHTML = circleText.textContent
    .split("")
    .map((char, index) => `<span style="transform: rotate(${index * 28.3}deg)">${char}</span>`)
    .join("");

/* ============== New Section ============== */

async function renderNewProducts() {
    const respone = await fetch(API_URL);
    const data = await respone.json();
    data.map((product) => {
        if (product.isNew) {
            newContent.innerHTML += ProductCard(product);
        }
    });
    const productCards = newContent.querySelectorAll(".product-card");
    productCards.forEach((product) => {
        product.classList.add("new__product");
        const image = product.querySelector("img");
        product.addEventListener("mouseover", () => {
            if (product.dataset.image2 != "undefined") {
                image.src = product.dataset.image2;
            }
        });
        product.addEventListener("mouseleave", () => {
            image.src = product.dataset.image1;
        });
    });
    /* Swiper JS */
    const newSwiper = new Swiper(".new__content", {
        slidesPerView: 4,
        spaceBetween: 20,
        loop: true,
        grabCursor: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 3,
            },
            1200: {
                slidesPerView: 4,
            },
        },
    });

    /* ScrollReveal JS */
    sr.reveal(newContent);
}

/* ============== Shop Section ============== */

async function renderShopProducts() {
    const respone = await fetch(API_URL);
    const data = await respone.json();
    data.map((product) => {
        shopContent.innerHTML += ProductCard(product);
    });
    const productCards = shopContent.querySelectorAll(".product-card");
    productCards.forEach((product) => {
        product.classList.add("shop__product");
        const image = product.querySelector("img");
        product.addEventListener("mouseover", () => {
            if (product.dataset.image2 != "undefined") {
                image.src = product.dataset.image2;
            }
        });
        product.addEventListener("mouseleave", () => {
            image.src = product.dataset.image1;
        });
    });

    /* ScrollReveal JS */
    sr.reveal(".shop__product", { interval: 100 });
}

/*=====SORTARE===========*/




/* Shop categories */
shopCategories.forEach((category) => {
    category.addEventListener("click", () => {
        shopCategories.forEach((category) => category.classList.remove("selected"));
        category.classList.add("selected");
        let categoryType = category.dataset.category;
        const shopProducts = document.querySelectorAll(".shop__product");
        shopProducts.forEach((product) => {
            product.classList.add("hide");
            if (product.dataset.category === categoryType || categoryType === "all") {
                product.classList.remove("hide");
            }
        });
    });
});


//////SORTARE
/*let sortedProducts = [];

document.getElementById('sortAscending').addEventListener('click', () => {
    const shopProducts = document.querySelectorAll('.shop__product');
    sortedProducts = Array.from(shopProducts).sort((a, b) => {
        const priceA = parseFloat(a.dataset.price);
        const priceB = parseFloat(b.dataset.price);
        return priceA - priceB;
    });
});

document.getElementById('displaySortedProducts').addEventListener('click', () => {
    const shopContent = document.querySelector('.shop__products');
    shopContent.innerHTML = '';
    sortedProducts.forEach((product) => {
        shopContent.appendChild(product.cloneNode(true));
    });
});


function displaySortedProducts() {
    const shopContent = document.querySelector('.shop__products');
    shopContent.innerHTML = '';
    sortedProducts.forEach((product) => {
        shopContent.appendChild(product.cloneNode(true));
    });
} 


/* ============== Trending Section ============== */

async function renderTrendingProducts() {
    const respone = await fetch(API_URL);
    const data = await respone.json();
    data.map((product) => {
        if (product.isTrending) {
            trendingContent.innerHTML += TrendingCard(product);
        }
    });
    /* Swiper JS */
    const trendingSectionSwiper = new Swiper(".trending__content", {
        loop: true,
        effect: "fade",
        speed: 600,
        allowTouchMove: false,
        autoplay: {
            delay: 6000,
        },
    });
    /* ScrollReveal JS */
    sr.reveal(trendingContent);
}

    // JavaScript to handle file input and display selected file names
    const photoInput = document.getElementById('photoInput');
    const selectedFilesContainer = document.getElementById('selectedFiles');

    photoInput.addEventListener('change', handleFileSelect);

    /*function handleFileSelect(event) {
        // Clear previous selections
        selectedFilesContainer.innerHTML = '';

        const files = event.target.files;
        if (files.length > 0) {
            for (const file of files) {
                const fileName = document.createElement('p');
                fileName.textContent = file.name;
                selectedFilesContainer.appendChild(fileName);
            }
        } else {
            selectedFilesContainer.innerHTML = 'No files selected.';
        }
    }*/

    function handleFileSelect() {
        const input = document.getElementById('photoInput');
        const files = input.files;
    
        const formData = new FormData();
        for (let i = 0; i < files.length; i++) {
            formData.append('photos[]', files[i]);
        }
    
        // Use fetch to send the files to your server
        fetch('upload.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            // Handle the response from the server (e.g., display success message)
            console.log(data);
        })
        .catch(error => {
            // Handle errors
            console.error('Error:', error);
        });
    }

/* ============== Brands Section ============== */

/* ScrollReveal JS */
sr.reveal(".brands__logo", { interval: 100 });

/* ============== Footer ============== */

/* ScrollReveal JS */
sr.reveal(".footer__col", { interval: 100 });


/* ============== Active Scroll ============== */

function activeScroll() {
    const scrollY = window.scrollY;
    sections.forEach((section) => {
        const sectionTop = section.offsetTop - 16,
            sectionHeight = section.offsetHeight,
            link = document.querySelector(`.header__link a[href='#${section.id}'`);
        if (scrollY >= sectionTop && scrollY <= sectionHeight + sectionTop) {
            link.classList.add("active");
        } else {
            link.classList.remove("active");
        }
    });
}

/* ============== Scroll Up ============== */

function showScrollUpBtn() {
    if (window.scrollY > 300) {
        scrollUpBtn.classList.add("show");
    } else {
        scrollUpBtn.classList.remove("show");
    }
}

scrollUpBtn.addEventListener("click", () => window.scrollTo({ behavior: "smooth", top: 0, left: 0 }));

/*==============Cont======================*/

document.addEventListener("DOMContentLoaded", function () {
    var modal = document.getElementById("myModal");
    var signupForm = document.getElementById("signupForm");
    var loginLink = document.getElementById("loginLink");
    var contLink = document.querySelector(".header__link a[href='#cont']");
    var closeBtn = document.getElementsByClassName("close")[0];

    // Function to open the modal
    function openModal() {
        modal.style.display = "block";
    }

    // Function to close the modal
    function closeModal() {
        modal.style.display = "none";
    }

    // Event listener for the "cont" link
    contLink.addEventListener("click", openModal);

    // Event listener for the close button
    closeBtn.addEventListener("click", closeModal);

    // Event listener for clicking outside the modal
    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Event listener for switching to the login form
    loginLink.addEventListener("click", function (event) {
        event.preventDefault();
        // Add logic to switch to the login form or navigate to a login page
        closeModal();
    });

    // Event listener for the signup form submission
    signupForm.addEventListener("submit", function (event) {
        event.preventDefault();
        // Add logic to handle the signup form submission
        // You can use the values of email and password fields for further processing
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;
        console.log("Email: " + email + ", Password: " + password);
        closeModal();
    });
});

/* ============== Call functions ============== */

window.addEventListener("scroll", () => {
    activeScroll();
    changeHeaderBg();
    showScrollUpBtn();
});

window.addEventListener("load", () => {
    activeScroll();
    renderNewProducts();
    renderShopProducts();
    renderTrendingProducts();
    document.querySelector(".home__slide").classList.add("reveal");
});


document.addEventListener("DOMContentLoaded", function () {
    // Function to hide sections when scrolling down
    function hideSectionsOnScroll() {
        const sectionsToHide = ["favorite", "cos-de-cumparaturi", "cont"];

        sectionsToHide.forEach((sectionId) => {
            const section = document.getElementById(sectionId);
            if (section) {
                section.style.display = "none";
            }
        });
    }

    // Initial call to hide sections on page load
    hideSectionsOnScroll();

    // Function to show/hide sections based on scroll direction
    function handleScroll() {
        const currentScrollPos = window.pageYOffset;

        if (currentScrollPos > 0) {
            // Scrolling down, hide sections
            hideSectionsOnScroll();
        } else {
            // Scrolling up, show sections
            const sectionsToShow = ["favorite", "cos-de-cumparaturi", "cont"];

            sectionsToShow.forEach((sectionId) => {
                const section = document.getElementById(sectionId);
                if (section) {
                    section.style.display = "block";
                }
            });
        }
    }

    // Event listener for scroll events
    window.addEventListener("scroll", handleScroll);
});
