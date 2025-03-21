<?php
include ('header.php');
include ('banner_header.php');
include('admin/includes/dbconnection.php'); 
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
      <p>To leverage my extensive experience in teaching, research, and knowledge management to foster academic excellence and innovation. I aim to mentor students, contribute 
        to impactful research, and integrate technology-driven learning methodologies to enhance the educational landscape.
      </p>
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
            <p>Focused on strategic management, business analytics, and organizational growth, conducting in-depth research to enhance decision-making and operational efficiency 
              while contributing to academic literature through publications and case studies.
            </p>
          </div><!-- Edn Resume Item -->

          <div class="resume-item">
            <h4>Masters in Computer Applications (MCA) &amp; Computer Science</h4>
            <h5>2010 - 2014</h5>
            <p><em>Punjabi University, Patiala</em></p>
            <p>Completed a Master's in Computer Applications (MCA) with a strong foundation in computer science, focusing on software development, data structures, and system 
              architecture. Gained expertise in advanced programming, database management, and emerging technologies.
            </p>
          </div><!-- Edn Resume Item -->
        </div>

        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
          <h3 class="resume-title">Professional Experience</h3>
          <div class="resume-item">
            <h4>Professor (IT & Knowledge Management)</h4>
            <h5>Feb 2022 - Present</h5>
            <p><em>Indian Institute of Foreign Trade (IIFT), New Delhi</em></p>
            <ul>
              <li>Train the Trainer program by SAP India on “SAP Analytics Cloud” using SAP system (30 September - 01 October 2021).</li>
              <li>Train the Trainer program by SAP India on “SAP S4HANA” using SAP system (27-29 September 2021). </li>
              <li>6-day FDP on "Sales Force Essentials for Business Specialists" by ICT Academy, held in New Delhi from 09 to 14 December 2019.</li>
              <li>3-Day FDP on "Data Science with Python" conducted by ICT Academy from 19 to 21 December 2019.</li>
            </ul>
          </div><!-- Edn Resume Item -->

          <div class="resume-item">
            <h4>Associate Professor</h4>
            <h5>2009 - 2022</h5>
            <p><em>Indian Institute of Foreign Trade (IIFT), New Delhi</em></p>
            <ul>
              <li>ICT Academy Certification on "Hortonworks Hadoop Developer" using the Hadoop Ecosystem, May 2018.</li>
              <li>One-week FDP on "Data Science and Big Data Analytics using R Studio" by ICT Academy.</li>
              <li>Train the Trainer program by SAP India on "Mobile Application Development" using SAP system in May 2013.</li>
              <li>Train the Trainer program by SAP India on “Business Intelligence” using SAP system from December 12 to December 16, 2011.</li>
            </ul>
          </div><!-- Edn Resume Item -->
        </div>
      </div>
    </div>
  </section><!-- /Resume Section -->

  <!-- Publications Section -->
  <section id="publications" class="portfolio section light-background py-5">
    <div class="container section-title" data-aos="fade-up">    
      <h2>Publications</h2>
      <p class="mb-4">Explore various research papers and conference articles</p>
      
      <div class="row g-4">
        <!-- International Journal -->
        <div class="col-md-6 col-lg-3">
          <div class="publication-box">
            <h3>International Journal</h3>
            <p class="mb-2">Explore recent international journal publications.</p>
            <ul class="list-unstyled" id="international-journal-list"></ul>
            <a href="view_all.php?category=International Journal" class="view-all" target='_blank'>View All</a>
          </div>
        </div>

        <!-- National Journal -->
        <div class="col-md-6 col-lg-3">
          <div class="publication-box">
            <h3>National Journal</h3>
            <p class="mb-2">Explore recent national journal publications.</p>
            <ul class="list-unstyled" id="national-journal-list"></ul>
            <a href="view_all.php?category=National Journal" class="view-all" target='_blank'>View All</a>
          </div>
        </div>

        <!-- International Conference -->
        <div class="col-md-6 col-lg-3">
          <div class="publication-box">
            <h3>International Conference</h3>
            <p class="mb-2">Latest international conference contributions.</p>
            <ul class="list-unstyled" id="international-conference-list"></ul>
            <a href="view_all.php?category=International Conference" class="view-all" target='_blank'>View All</a>
          </div>
        </div>

        <!-- National Conference -->
        <div class="col-md-6 col-lg-3">
          <div class="publication-box">
            <h3>National Conference</h3>
            <p class="mb-2">Recent national conference publications.</p>
            <ul class="list-unstyled" id="national-conference-list"></ul>
            <a href="view_all.php?category=National Conference" class="view-all" target='_blank'>View All</a>
          </div>
        </div>
      </div>
    </div>
  </section><!-- /Publications Section -->

  <script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchPublications("International Journal", "international-journal-list");
        fetchPublications("National Journal", "national-journal-list");
        fetchPublications("International Conference", "international-conference-list");
        fetchPublications("National Conference", "national-conference-list");
    });

    function fetchPublications(category, listId) {
        fetch(`fetch_publications.php?category=${category}`)
            .then(response => response.json())
            .then(data => {
                let list = document.getElementById(listId);
                list.innerHTML = ""; // Clear existing list
                data.forEach((item, index) => {
                    let li = document.createElement("li");
                    li.className = "mb-2";
                    li.innerHTML = `${index + 1}. ${item.title}`;
                    list.appendChild(li);
                });
            })
            .catch(error => console.error("Error fetching data:", error));
    }
  </script>

  <!-- Courses Section -->
  <?php
    $sql = "SELECT * FROM tblcourse";
    $query = $dbh->prepare($sql);
    $query->execute();
    $courses = $query->fetchAll(PDO::FETCH_OBJ);
  ?>

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
                <a href="categories.php?course_id=<?php echo $course->ID; ?>" class="stretched-link" target="_blank">
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

  <!-- Portfolio Section -->
  <?php
    // Fetch Books Data
    $book_sql = "SELECT * FROM books ORDER BY id DESC";
    $book_query = $dbh->prepare($book_sql);
    $book_query->execute();
    $books = $book_query->fetchAll(PDO::FETCH_OBJ);

    // Fetch only active announcements (not expired)
    $current_date = date('Y-m-d');
    $sql = "SELECT * FROM announcements WHERE expiry_date >= :current_date ORDER BY created_at DESC";
    $query = $dbh->prepare($sql);
    $query->bindParam(':current_date', $current_date, PDO::PARAM_STR);
    $query->execute();
    $posts = $query->fetchAll(PDO::FETCH_OBJ);
  ?>

  <section id="portfolio" class="portfolio section light-background">
    <div class="container section-title" data-aos="fade-up">
      <h2>Portfolio</h2>
      <p>Check out the latest books and announcements.</p>
    </div>
    <div class="container">
      <div class="row">
        <!-- 📚 Books Section (8-column wide) -->
        <div class="col-lg-8">
          <!-- Section Heading -->
          <h3 class="text-center mb-4">📚 Books Collection</h3>
          <div class="row gy-4">
            <?php foreach ($books as $book) { ?>
              <div class="col-lg-4 col-md-6 col-sm-12"> <!-- Responsive Grid -->
                <div class="card book-card position-relative shadow-sm border rounded overflow-hidden">                      
                  <!-- Book Image -->
                  <img src="admin/uploads/books/<?php echo $book->book_image; ?>" class="card-img-top book-thumbnail" alt="<?php echo $book->title; ?>">
                  <!-- Overlay Effect -->
                  <div class="book-overlay d-flex flex-column justify-content-center align-items-center text-center">
                    <h5 class="book-title"><?php echo $book->title; ?></h5>
                    <a href="book_details.php?id=<?php echo $book->ID; ?>" class="btn btn-light btn-sm mt-2 shadow-sm" title="More Details" target="_blank">
                      <i class="bi bi-link-45deg"></i> Read More
                    </a>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>

        <!-- Announcements Section (Auto-Scrolling) -->
        <div class="col-lg-4">
          <!-- Section Heading -->
          <h3 class="text-center mb-3">📢 Announcements</h3>
          <div class="card shadow border rounded">
            <!-- Header Section -->
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
              <h5 class="mb-0">Latest Updates</h5>
              <a href="view_all_announcements.php" class="text-white small" target="_blank">View All →</a>
            </div>

            <!-- Announcement List with Auto-Scroll -->
            <div class="card-body p-3" style="height: 250px; overflow: hidden;">
              <ul class="announcement-list list-unstyled mb-0">
                <?php foreach ($posts as $post) { ?>
                  <li class="p-2 d-flex justify-content-between align-items-center border-bottom">
                    <div>
                      <i class="bi bi-arrow-right-circle text-primary me-2"></i> 
                      <strong><?php echo $post->title; ?></strong>
                      <!-- <a href="announcement-details.php?id=<?php echo $post->id; ?>" class="btn btn-sm btn-primary">
                        <i class="bi bi-arrow-right-circle"></i>
                      </a> -->
                    </div>
                    <small class="text-muted">
                      <?php echo "Last date - " . date("d.m.Y", strtotime($post->expiry_date)); ?>
                    </small>
                  </li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section><!-- /Portfolio Section -->

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
<script>
  $(document).ready(function () {
      function scrollAnnouncements() {
          let firstItem = $(".announcement-list li:first");
          firstItem.slideUp(500, function () {
              $(this).appendTo(".announcement-list").slideDown(500);
          });
      }

      setInterval(scrollAnnouncements, 3000); // Scroll every 3 seconds
  });
</script>