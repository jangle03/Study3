
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study3 - Trang chủ học tập</title>
    <meta name="description" content="Study3 - Nền tảng học tập trực tuyến hàng đầu Việt Nam với các khóa học chất lượng cao">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/root.css">
    <link rel="stylesheet" href="../src/css/intro.css">
    <link rel="stylesheet" href="../src/css/header.css">
   
</head>
<body>
<header>
    <a href="../">
        <img src="../src/images/logo.png" alt="logo" class="header-logo">
    </a>
    <a href="/login/" class="login-button">Login</a>
</header>


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
                    </div>
                </div>
                <div class="tool-card">
                    <div class="tool-icon">
                        <i class="fas fa-align-left"></i>
                    </div>
                    <div class="tool-content">
                        <h3 class="tool-title">Sentence Library</h3>
                        <p class="tool-description">Create and store sentences using your vocabulary. Add translations to better understand context and usage.</p>
                    
                    </div>
                </div>
                <div class="tool-card">
                    <div class="tool-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="tool-content">
                        <h3 class="tool-title">Texts & Reading</h3>
                        <p class="tool-description">Upload and translate texts for reading practice. Improve your reading comprehension and expand your vocabulary through real-world context.</p>
                      
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
    </div>

    <div class="container">
        <h2 class="section-title">NEWS</h2>
        <div class="content">
            <?php
                require_once '../config.php';
                $db = new Database();
                $posts = $db->select('blog', '*', 'WHERE status = 1 ORDER BY created_at DESC LIMIT 5');

                if (!$posts) {
                    echo "<div class='no-posts'>";
                    echo "<i class='fas fa-newspaper' style='font-size: 40px; color: #ddd; margin-bottom: 15px;'></i>";
                    echo "<p>Chưa có bài đăng nào. Hãy quay lại sau!</p>";
                    echo "</div>";
                } else {
                    foreach ($posts as $post): 
                        $author = $db->find('users', $post['id_users'])[0];
                        $avatar = !empty($author['profile_picture']) ? $author['profile_picture'] : 'default.png';
                        
                        // Tạo đoạn tóm tắt nội dung
                        $summary = strlen($post['content']) > 300 ? 
                            substr($post['content'], 0, 300) . '...' : $post['content'];
            ?>
            <div class="post">
                <div class="post-header">
                    <img src="../src/images/profile-image/<?php echo htmlspecialchars($avatar); ?>" 
                        alt="Profile Image" class="post-avatar">
                    <div>
                        <span class="post-author"><?php echo htmlspecialchars($author['username']); ?></span>
                        <p class="post-meta"><?php echo date('d/m/Y H:i', strtotime($post['created_at'])); ?></p>
                    </div>
                </div>

                <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($summary)); ?></p>
                
                <?php if ($post['image']): ?>
                    <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image" class="post-image">
                <?php endif; ?>
          
            </div>
            <?php 
                    endforeach; 
                }
            ?>
            
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
  

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Animation for feature cards
            $('.feature-card').hover(
                function() {
                    $(this).css('transform', 'translateY(-10px)');
                },
                function() {
                    $(this).css('transform', 'translateY(0)');
                }
            );
            
            // Smooth scrolling for anchor links
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if( target.length ) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 100
                    }, 1000);
                }
            });
            
            // Newsletter form submission
            $('.newsletter-form').on('submit', function(e) {
                e.preventDefault();
                var email = $(this).find('input[type="email"]').val();
                
                // Here you would normally send this to a server
                alert('Cảm ơn bạn đã đăng ký nhận bản tin với email: ' + email);
                $(this).find('input[type="email"]').val('');
            });
        });
    </script>
</body>
</html>