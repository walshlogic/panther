<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<!-- Footer -->
<!-- php code gets current year from server to populate copyright year -->
<footer class="sticky-footer bg-white fixed-bottom">
    <div class="container my-auto">
        <div class="copyright text-center my-auto"> <?php require_once './logic/footer_modals.php'; ?> <span
                class="text-muted">&copy; Property Apprasier <?php echo date("Y") ?> | Putnam County Florida | <a
                    data-toggle="modal"
                    href="#termsofuse">Terms of Use</a> | <a data-toggle="modal"
                    href="#privacypolicy">Privacy Policy</a> | <a data-toggle="modal"
                    href="#docsformsdisclaimer">Doucment & Form Disclaimer</a></span>
        </div>
    </div>
</footer>
<!-- End of Footer -->