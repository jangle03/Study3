<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study3 - Your Personal English Learning Platform</title>
    <link rel="icon" type="image/png" sizes="16x16" href="favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./src/css/home.css">
    <link rel="stylesheet" href="./src/css/home1.css">
    <link rel="stylesheet" href="./src/css/footer.css">
    <link rel="stylesheet" href="./src/css/header.css">
    <link rel="stylesheet" href="./src/css/sweetalert2.css">
</head>

<body>
    <?php include './includes/header.php'; ?>

    <div class="container">
        <section class="hero-section">
            <h1>Build Your English Skills with Study3</h1>
            <p>A personalized English learning platform that helps you improve your vocabulary, sentence structure, and reading skills with interactive learning tools and exercises.</p>
        </section>

        <section class="features-section">
            <div class="feature-card">
                <i class="fas fa-user-plus feature-icon"></i>
                <div class="feature-content">
                    <h3>Personalized Learning</h3>
                    <p>Create and manage your own library of vocabulary, sentences, and texts. Study3 allows you to build learning materials tailored to your individual needs.</p>
                </div>
            </div>
            <div class="feature-card">
                <i class="fas fa-dumbbell feature-icon"></i>
                <div class="feature-content">
                    <h3>Interactive Practice</h3>
                    <p>Test your knowledge with vocabulary and sentence exercises designed to enhance memory retention and improve language skills.</p>
                </div>
            </div>
            <div class="feature-card">
                <i class="fas fa-download feature-icon"></i>
                <div class="feature-content">
                    <h3>Download & Review</h3>
                    <p>Easily export your learning materials as PDFs for offline studying and track your learning progress over time.</p>
                </div>
            </div>
        </section>

        <section class="tools-section">
            <h2 class="section-heading">Our Learning Tools</h2>
            <div class="tools-grid">
                <div class="tool-card">
                    <div class="tool-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="tool-content">
                        <h3 class="tool-title">Personal Dictionary</h3>
                        <p class="tool-description">Add new vocabulary along with translations and definitions. Build your own vocabulary library for easy review.</p>
                        <div class="tool-link">
                            <a href="./dictionary/" class="btn-primary">Explore Dictionary</a>
                        </div>
                    </div>
                </div>
                <div class="tool-card">
                    <div class="tool-icon">
                        <i class="fas fa-align-left"></i>
                    </div>
                    <div class="tool-content">
                        <h3 class="tool-title">Sentence Library</h3>
                        <p class="tool-description">Create and store sentences using your vocabulary. Add translations to better understand context and usage.</p>
                        <div class="tool-link">
                            <a href="./sentences/" class="btn-primary">View Sentences</a>
                        </div>
                    </div>
                </div>
                <div class="tool-card">
                    <div class="tool-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="tool-content">
                        <h3 class="tool-title">Texts & Reading</h3>
                        <p class="tool-description">Upload and translate texts for reading practice. Improve your reading comprehension and expand your vocabulary through real-world context.</p>
                        <div class="tool-link">
                            <a href="./texts/" class="btn-primary">View Texts</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="exercises-section">
            <div class="exercises-container">
                <h2 class="section-heading">Practice & Testing</h2>
                <div class="exercise-cards">
                    <div class="exercise-card">
                        <div class="exercise-icon">
                            <i class="fas fa-random"></i>
                        </div>
                        <h3 class="exercise-title">Vocabulary Tests</h3>
                        <p class="exercise-description">Challenge yourself with vocabulary tests where words are scrambled and you must choose the correct answer from four options.</p>
                    </div>
                    <div class="exercise-card">
                        <div class="exercise-icon">
                            <i class="fas fa-sort-amount-up"></i>
                        </div>
                        <h3 class="exercise-title">Sentence Ordering</h3>
                        <p class="exercise-description">Improve your grammar and sentence structure by rearranging scrambled sentences to form complete, grammatically correct sentences.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="how-it-works">
            <h2 class="section-heading">How Study3 Works</h2>
            <div class="steps-container">
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3 class="step-title">Create Your Personal English Library</h3>
                        <p class="step-description">Start by adding your own vocabulary, sentences, and texts to your personal library. Favorite important items for quick access later.</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3 class="step-title">Practice with Interactive Exercises</h3>
                        <p class="step-description">Test your knowledge with vocabulary and sentence exercises. The consistent practice method helps improve memory retention and language skills.</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3 class="step-title">Track Progress & Download Materials</h3>
                        <p class="step-description">Export your learning materials as PDFs for offline study. Use the search function to quickly access content when needed.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="cta-section">
            <h2>Start Your English Journey Today</h2>
            <p>Create a free account and make the most of Study3's personalized learning tools to improve your English skills.</p>
            
            <div class="features-list">
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <div class="feature-text">Add vocabulary & definitions</div>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <div class="feature-text">Create & store sentences</div>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <div class="feature-text">Upload texts for reading</div>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <div class="feature-text">Practice with tests</div>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <div class="feature-text">Download PDF materials</div>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <div class="feature-text">Quick search functionality</div>
                </div>
            </div>
        </section>
    </div>

    <?php include './includes/footer.php'; ?>

    <script>
        // Animation for elements
        const animateElements = () => {
            const elements = document.querySelectorAll('.feature-card, .tool-card, .exercise-card, .step');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.transform = 'translateY(0)';
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.2 });
            
            elements.forEach(el => {
                el.style.opacity = 0;
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                observer.observe(el);
            });
        };
        
        // Initialize animations when DOM is fully loaded
        document.addEventListener('DOMContentLoaded', () => {
            animateElements();
        });
    </script>
</body>

</html>