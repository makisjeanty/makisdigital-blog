// Navbar scroll effect
window.addEventListener('scroll', () => {
    const navbar = document.getElementById('blogNavbar');
    if (!navbar) return;

    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// Intersection Observer for animations
document.addEventListener('DOMContentLoaded', () => {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                // Optional: Unobserve if you only want it once
                // observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const animateElements = document.querySelectorAll('.animate-fade-in, .post-card, .expertise-card, .featured-post-card');
    animateElements.forEach(el => {
        observer.observe(el);
    });

    // Home Newsletter AJAX
    const homeNewsletterForm = document.getElementById('homeNewsletterForm');
    if (homeNewsletterForm) {
        homeNewsletterForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const emailInput = homeNewsletterForm.querySelector('input[name="email"]');
            const email = emailInput.value;
            const statusDiv = document.getElementById('homeNewsletterStatus');
            const submitBtn = homeNewsletterForm.querySelector('button');

            submitBtn.disabled = true;
            submitBtn.innerText = '...';

            try {
                const response = await fetch(homeNewsletterForm.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email })
                });

                const data = await response.json();

                statusDiv.style.display = 'block';
                if (response.ok) {
                    statusDiv.style.color = '#34d399';
                    statusDiv.innerText = data.message;
                    homeNewsletterForm.reset();
                } else {
                    statusDiv.style.color = '#f87171';
                    statusDiv.innerText = data.errors?.email?.[0] || 'Ocorreu um erro.';
                }
            } catch (error) {
                statusDiv.style.display = 'block';
                statusDiv.style.color = '#f87171';
                statusDiv.innerText = 'Erro na conexão.';
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerText = 'Fazer parte da lista';
            }
        });
    }

    // Newsletter AJAX (Footer)
    const newsletterForm = document.getElementById('newsletterForm');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = newsletterForm.querySelector('input[name="email"]').value;
            const statusDiv = document.getElementById('newsletterStatus');
            const submitBtn = newsletterForm.querySelector('button');

            submitBtn.disabled = true;
            submitBtn.innerText = '...';

            try {
                const response = await fetch(newsletterForm.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email })
                });

                const data = await response.json();

                statusDiv.style.display = 'block';
                if (response.ok) {
                    statusDiv.style.color = '#34d399';
                    statusDiv.innerText = data.message;
                    newsletterForm.reset();
                } else {
                    statusDiv.style.color = '#f87171';
                    statusDiv.innerText = data.errors?.email?.[0] || 'Ocorreu um erro.';
                }
            } catch (error) {
                statusDiv.style.display = 'block';
                statusDiv.style.color = '#f87171';
                statusDiv.innerText = 'Erro na conexão.';
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerText = 'Assinar';
            }
        });
    }
});
