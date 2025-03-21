<footer id="footer" class="footer position-relative light-background">
  <div class="container">
    <div class="d-flex justify-content-center justify-content-md-between align-items-center flex-wrap">
      <div class="text-center flex-grow-1">
        <p class="m-0">
          © <span>Copyright</span> <strong class="px-1 sitename">2025</strong> <span>All Rights Reserved</span>
        </p>
        <div class="credits mt-2">
          Designed by <a href="#">Sunny</a>
        </div>
      </div>
      <div class="text-md-end">
        <p class="m-0">
          Total Visitors: <strong><?php include 'counter.php'; ?></strong>
        </p>
        <p class="last-update m-0 mt-2">
          Last Updated: <strong id="last-updated-text"></strong>
        </p>
      </div>
    </div>
  </div>
</footer>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
  <i class="bi bi-arrow-up-short"></i>
</a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/typed.js/typed.umd.js"></script>
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

<!-- Main JS File -->
<script src="assets/js/main.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $(".php-email-form").submit(function(event) {
        event.preventDefault(); // Prevent page refresh
        var formData = $(this).serialize(); // Serialize form data

        $.ajax({
            type: "POST",
            url: "contact.php",
            data: formData,
            dataType: "json",
            success: function(response) {
                $(".sent-message, .error-message").hide(); // Hide any previous messages

                if (response.status == "success") {
                    $(".sent-message").html(response.message).fadeIn();
                    $(".php-email-form")[0].reset(); // Reset form after success
                } else {
                    $(".error-message").html(response.message).fadeIn();
                }

                setTimeout(function() {
                    $(".sent-message, .error-message").fadeOut(); // Hide message after 3 seconds
                }, 2000);
            }
        });
    });
});
    

function updateLastUpdated() {
fetch('last_update.php?nocache=' + new Date().getTime()) // Cache busting
.then(response => response.text())
.then(data => {
    document.getElementById('last-updated-text').innerHTML = data;
})
.catch(error => console.error('Error fetching last update:', error));
}

updateLastUpdated(); // Load initially
setInterval(updateLastUpdated, 5000); // Refresh every 5 seconds

</script>
