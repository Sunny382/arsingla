<?php
include ('header.php');
include ('banner_header.php');
include('admin/includes/dbconnection.php'); // Database connection
?>

    <!-- About Section -->
    <section id="about" class="about section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>About</h2>
        <p>As a dedicated professor, I am committed to fostering academic excellence and intellectual growth. With a passion for teaching and research, I strive to inspire students and contribute meaningfully to my field. My goal is to create a dynamic learning environment that encourages critical thinking, innovation, and lifelong learning.</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4 justify-content-center">
          <div class="col-lg-4">
            <img src="assets/img/drsingla.jpeg" class="img-fluid" alt="" style="height: 425px;width: 400px;border-radius: 15px;">
          </div>
          <div class="col-lg-8 content">
            <h2>Professor (IT and Knowledge Management) &amp; Controller of Examination , Head (Computer Centre).</h2>
            <p class="fst-italic py-3">
              As a Professor in IT and Knowledge Management, Controller of Examination, and Head of the Computer Centre, I lead efforts in enhancing education through technology and 
              innovation. My focus includes curriculum development, exam administration, and managing IT infrastructure to support academic excellence.
            </p>
            <div class="row">
              <div class="col-lg-6">
                <ul>
                  <li><i class="bi bi-chevron-right"></i> <strong>Scopus ID:</strong> <span>55371874800</span></li>
                  <li><i class="bi bi-chevron-right"></i> <strong>Website:</strong> <span>www.example.com</span></li>
                  <li><i class="bi bi-chevron-right"></i> <strong>Phone:</strong> <span>9350732238</span></li>
                  <li><i class="bi bi-chevron-right"></i> <strong>City:</strong> <span>Gurgaon</span></li>
                </ul>
              </div>
              <div class="col-lg-6">
                <ul>
                  <li><i class="bi bi-chevron-right"></i> <strong>Age:</strong> <span>48</span></li>
                  <li><i class="bi bi-chevron-right"></i> <strong>Degree:</strong> <span>PhD</span></li>
                  <li><i class="bi bi-chevron-right"></i> <strong>Email:</strong> <span>arsingla@iift.edu; ashim.singla@gmail.com</span></li>
                  <li><i class="bi bi-chevron-right"></i> <strong>Orcid ID:</strong> <span>https://orcid.org/0009-0000-1417-267X</span></li>
                </ul>
              </div>
            </div>
            <p class="py-3">
              With a PhD and expertise in IT and Knowledge Management, I focus on advancing research, teaching, and innovation. My contributions are reflected in my Scopus and Orcid IDs, shaping the future of education and technology.
            </p>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Stats Section -->
    <section id="stats" class="stats section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-3 col-md-6">
            <div class="stats-item">
              <i class="bi bi-emoji-smile"></i>
              <span data-purecounter-start="0" data-purecounter-end="232" data-purecounter-duration="1" class="purecounter"></span>
              <p><strong>Happy Clients</strong> <span>consequuntur quae</span></p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6">
            <div class="stats-item">
              <i class="bi bi-journal-richtext"></i>
              <span data-purecounter-start="0" data-purecounter-end="521" data-purecounter-duration="1" class="purecounter"></span>
              <p><strong>Projects</strong> <span>adipisci atque cum quia aut</span></p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6">
            <div class="stats-item">
              <i class="bi bi-headset"></i>
              <span data-purecounter-start="0" data-purecounter-end="1453" data-purecounter-duration="1" class="purecounter"></span>
              <p><strong>Hours Of Support</strong> <span>aut commodi quaerat</span></p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6">
            <div class="stats-item">
              <i class="bi bi-people"></i>
              <span data-purecounter-start="0" data-purecounter-end="32" data-purecounter-duration="1" class="purecounter"></span>
              <p><strong>Hard Workers</strong> <span>rerum asperiores dolor</span></p>
            </div>
          </div><!-- End Stats Item -->
        </div>
      </div>
    </section><!-- /Stats Section -->

    <!-- Skills Section -->
    <?php        
      try {
          $sql = "SELECT * FROM skills ORDER BY category, proficiency DESC";
          $stmt = $dbh->prepare($sql);
          $stmt->execute();
          $skills = $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
          echo "Error fetching skills: " . $e->getMessage();
      }
    ?>
    <!-- Skills Section -->
    <section id="skills" class="skills section light-background">
        <div class="container section-title" data-aos="fade-up">
            <h2>Skills</h2>
            <p>My expertise encompasses a wide range of skills, including Data Analytics, Big Data, ERP systems, and Information Systems, which enable me to drive innovation and 
              excellence in both academic and professional environments. I am committed to leveraging these skills to create impactful solutions and foster knowledge advancement.
            </p>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row skills-content skills-animation">
                <?php
                if (!empty($skills)) {
                    $categories = [];
                    foreach ($skills as $skill) {
                        $categories[$skill['category']][] = $skill;
                    }

                    $half = ceil(count($categories) / 2);
                    $chunks = array_chunk($categories, $half, true);

                    foreach ($chunks as $chunk) {
                        echo '<div class="col-lg-6">';
                        foreach ($chunk as $category => $skillList) {
                            echo "<h4 class='text-primary'>$category</h4>";
                            foreach ($skillList as $skill) {
                                echo "
                                <div class='progress'>
                                    <span class='skill'><span>{$skill['skill_name']}</span> <i class='val'>{$skill['proficiency']}%</i></span>
                                    <div class='progress-bar-wrap'>
                                        <div class='progress-bar' role='progressbar' aria-valuenow='{$skill['proficiency']}' aria-valuemin='0' aria-valuemax='100' style='width: {$skill['proficiency']}%;'></div>
                                    </div>
                                </div>";
                            }
                        }
                        echo '</div>';
                    }
                } else {
                    echo "<p class='text-center text-danger'>No skills found.</p>";
                }
                ?>
            </div>
        </div>
    </section><!-- Skills Section -->

    <!-- Resume Section -->
    <section id="resume" class="resume section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Resume</h2>
        <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row">

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <h3 class="resume-title">Sumary</h3>

            <div class="resume-item pb-0">
              <h4>Dr. Ashim Raj Singla</h4>
              <p><em> 24+ years of experience in academics, Information systems development & implementation. Worked in the field of Data Analytics, Developing e-Commerce solutions, Enterprise Applications and Embedded systems.</em></p>
              <ul>
                <li>IIFT Bhawan, B-21, Qutab Institutional Area, New Delhi - 110016</li>
                <li>9350732238</li>
                <li>arsingla@iift.edu, ashim.singla@gmail.com</li>
              </ul>
            </div><!-- Edn Resume Item -->

            <h3 class="resume-title">Education</h3>
            <div class="resume-item">
              <h4>PhD &amp; Faculty of Business Management</h4>
              <h5>2015 - 2016</h5>
              <p><em>Punjabi University, Patiala</em></p>
              <p>Qui deserunt veniam. Et sed aliquam labore tempore sed quisquam iusto autem sit. Ea vero voluptatum qui ut dignissimos deleniti nerada porti sand markend</p>
            </div><!-- Edn Resume Item -->

            <div class="resume-item">
              <h4>Masters in Computer Applications (MCA) &amp; Computer Science</h4>
              <h5>2010 - 2014</h5>
              <p><em>Punjabi University, Patiala</em></p>
              <p>Quia nobis sequi est occaecati aut. Repudiandae et iusto quae reiciendis et quis Eius vel ratione eius unde vitae rerum voluptates asperiores voluptatem Earum molestiae consequatur neque etlon sader mart dila</p>
            </div><!-- Edn Resume Item -->

          </div>

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <h3 class="resume-title">Professional Experience</h3>
            <div class="resume-item">
              <h4>Professor (IT & Knowledge Management)</h4>
              <h5>Feb 2022 - Present</h5>
              <p><em>Indian Institute of Foreign Trade (IIFT), New Delhi</em></p>
              <ul>
                <li>Lead in the design, development, and implementation of the graphic, layout, and production communication materials</li>
                <li>Delegate tasks to the 7 members of the design team and provide counsel on all aspects of the project. </li>
                <li>Supervise the assessment of all graphic materials in order to ensure quality and accuracy of the design</li>
                <li>Oversee the efficient use of production project budgets ranging from $2,000 - $25,000</li>
              </ul>
            </div><!-- Edn Resume Item -->

            <div class="resume-item">
              <h4>Associate Professor</h4>
              <h5>2009 - 2022</h5>
              <p><em>Indian Institute of Foreign Trade (IIFT), New Delhi</em></p>
              <ul>
                <li>Developed numerous marketing programs (logos, brochures,infographics, presentations, and advertisements).</li>
                <li>Managed up to 5 projects or tasks at a given time while under pressure</li>
                <li>Recommended and consulted with clients on the most appropriate graphic design</li>
                <li>Created 4+ design presentations and proposals a month for clients and account managers</li>
              </ul>
            </div><!-- Edn Resume Item -->
          </div>
        </div>
      </div>
    </section><!-- /Resume Section -->

    <!-- Publications Section -->
    <?php
      // Fetch publications
      $sql = "SELECT * FROM publications ORDER BY category";
      $query = $dbh->prepare($sql);
      $query->execute();
      $results = $query->fetchAll(PDO::FETCH_OBJ);
    ?>

    <!-- Publications Section -->
    <section id="portfolio" class="portfolio section light-background">
      <div class="container section-title" data-aos="fade-up">
          <h2>Publication</h2>
          <p>Explore various research papers, conference articles, and books.</p>
      </div>

      <div class="container">
          <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
              <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
                  <li data-filter="*" class="filter-active">All</li>
                  <li data-filter=".filter-conference">Conference</li>
                  <li data-filter=".filter-research">Research Paper</li>
                  <li data-filter=".filter-books">Books</li>
              </ul>

              <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
                  <?php foreach ($results as $row) { ?>
                      <div class="col-lg-4 col-md-6 portfolio-item isotope-item <?php echo htmlentities($row->filter_class); ?>">
                          <div class="portfolio-content h-100">
                              <img src="<?php echo 'admin/uploads/publication/' . htmlentities($row->image); ?>" class="img-fluid" alt="">
                              <div class="portfolio-info">
                                  <h4><?php echo htmlentities($row->title); ?></h4>
                                  <p><?php echo htmlentities($row->description); ?></p>
                                  <a href="<?php echo 'admin/uploads/publication/' . htmlentities($row->image); ?>" title="<?php echo htmlentities($row->title); ?>" data-gallery="portfolio-gallery" class="glightbox preview-link">
                                      <i class="bi bi-zoom-in"></i>
                                  </a>
                              </div>
                          </div>
                      </div>
                  <?php } ?>
              </div>
          </div>
      </div>
    </section><!-- /Publications Section -->


    <!-- Services Section -->
    <!-- <section id="services" class="services section">    
      <div class="container section-title" data-aos="fade-up">
        <h2>Services</h2>
        <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
      </div>

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="100">
            <div class="icon flex-shrink-0"><i class="bi bi-briefcase"></i></div>
            <div>
              <h4 class="title"><a href="service-details.html" class="stretched-link">Lorem Ipsum</a></h4>
              <p class="description">Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident</p>
            </div>
          </div>
          

          <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="200">
            <div class="icon flex-shrink-0"><i class="bi bi-card-checklist"></i></div>
            <div>
              <h4 class="title"><a href="service-details.html" class="stretched-link">Dolor Sitema</a></h4>
              <p class="description">Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat tarad limino ata</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="300">
            <div class="icon flex-shrink-0"><i class="bi bi-bar-chart"></i></div>
            <div>
              <h4 class="title"><a href="service-details.html" class="stretched-link">Sed ut perspiciatis</a></h4>
              <p class="description">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="400">
            <div class="icon flex-shrink-0"><i class="bi bi-binoculars"></i></div>
            <div>
              <h4 class="title"><a href="service-details.html" class="stretched-link">Magni Dolores</a></h4>
              <p class="description">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="500">
            <div class="icon flex-shrink-0"><i class="bi bi-brightness-high"></i></div>
            <div>
              <h4 class="title"><a href="service-details.html" class="stretched-link">Nemo Enim</a></h4>
              <p class="description">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="600">
            <div class="icon flex-shrink-0"><i class="bi bi-calendar4-week"></i></div>
            <div>
              <h4 class="title"><a href="service-details.html" class="stretched-link">Eiusmod Tempor</a></h4>
              <p class="description">Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi</p>
            </div>
          </div>

        </div>

      </div>

    </section> -->
    <!-- /Services Section -->


  <?php
    $sql = "SELECT * FROM tblcourse";
    $query = $dbh->prepare($sql);
    $query->execute();
    $courses = $query->fetchAll(PDO::FETCH_OBJ);
  ?>

  <!-- Courses Section -->
  <section id="courses" class="courses section">
    <div class="container section-title" data-aos="fade-up">
      <h2>Courses</h2>
      <p>Explore our variety of technical and management courses designed for your growth.</p>
    </div>

    <div class="container">
      <div class="row gy-4">

        <?php foreach ($courses as $course) { ?>
          <div class="col-lg-4 col-md-6 courses-item d-flex" data-aos="fade-up">
            <div class="icon flex-shrink-0"><i class="<?php echo htmlspecialchars($course->icon_class); ?>"></i></div>
            <div>
              <h4 class="title">
                <a href="categories.php?course_id=<?php echo $course->ID; ?>" class="stretched-link">
                  <?php echo htmlspecialchars($course->course_code); ?>
                </a>
              </h4>
              <p class="description"><?php echo htmlspecialchars($course->description); ?></p>
            </div>
          </div>
        <?php } ?>

      </div>
    </div>
  </section><!-- /Courses Section -->




    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Testimonials</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 1,
                  "spaceBetween": 40
                },
                "1200": {
                  "slidesPerView": 3,
                  "spaceBetween": 1
                }
              }
            }
          </script>
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-item">
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
                <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                <h3>Saul Goodman</h3>
                <h4>Ceo &amp; Founder</h4>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
                <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
                <h3>Sara Wilsson</h3>
                <h4>Designer</h4>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
                <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                <h3>Jena Karlis</h3>
                <h4>Store Owner</h4>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
                <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
                <h3>Matt Brandon</h3>
                <h4>Freelancer</h4>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
                <img src="assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
                <h3>John Larson</h3>
                <h4>Entrepreneur</h4>
              </div>
            </div><!-- End testimonial item -->

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </section><!-- /Testimonials Section -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p>Should you have any inquiries, require academic assistance, or wish to discuss research collaborations, please do not hesitate to contact me. I am available via email or through the contact form for any updates or queries.
        </p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-5">

            <div class="info-wrap">
              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                <i class="bi bi-geo-alt flex-shrink-0"></i>
                <div>
                  <h3>Address</h3>
                  <p>B2, 1202, Uniworld Garden 2, Sector 47, Sohna Road, Gurgaon</p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                <i class="bi bi-telephone flex-shrink-0"></i>
                <div>
                  <h3>Call Us</h3>
                  <p>9350732238 </p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                <i class="bi bi-envelope flex-shrink-0"></i>
                <div>
                  <h3>Email Us</h3>
                  <p>arsingla@iift.edu, ashim.singla@gmail.com</p>
                </div>
              </div><!-- End Info Item -->
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3505.095912739307!2d77.18081717616174!3d28.536836688418838!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d1de532a48b5b%3A0xa0f3f30c1f26404c!2sIndian%20Institute%20of%20Foreign%20Trade!5e0!3m2!1sen!2sin!4v1738303602517!5m2!1sen!2sin" frameborder="0" style="border:0; width: 100%; height: 270px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>

          <div class="col-lg-7">
            <form action="contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">

                <div class="col-md-6">
                  <label for="name-field" class="pb-2">Your Name</label>
                  <input type="text" name="name" id="name-field" class="form-control" required="">
                </div>
                
                <div class="col-md-6">
                  <label for="email-field" class="pb-2">Your Email</label>
                  <input type="email" class="form-control" name="email" id="email-field" required="">
                </div>

                <div class="col-md-12">
                  <label for="subject-field" class="pb-2">Subject</label>
                  <input type="text" class="form-control" name="subject" id="subject-field" required="">
                </div>

                <div class="col-md-12">
                  <label for="message-field" class="pb-2">Message</label>
                  <textarea class="form-control" name="message" rows="10" id="message-field" required=""></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <!-- <div class="loading">Loading</div> -->
                  <div class="error-message"></div>
                  <div class="sent-message"></div>                 

                <button type="submit">Send Message</button>
                </div>
              </div>
            </form>
          </div><!-- End Contact Form -->
        </div>
      </div>
    </section><!-- /Contact Section -->
  </main>

<?php
include ('footer.php');
?>
