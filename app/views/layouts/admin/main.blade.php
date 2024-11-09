<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include 'elements/head.php'; ?>
   </head>
   <body>
      <div class='loader'>
         <div class='spinner-grow text-primary' role='status'>
            <span class='sr-only'>Loading...</span>
         </div>
      </div>
      <div id="page-overlay" class="visible incoming"> <div class="loader-wrapper-outer"> <div class="loader-wrapper-inner"> <div class="lds-double-ring"> <div></div> <div></div> <div> <div></div> </div> <div> <div></div> </div> </div> </div> </div> </div>
      
      <div class="page-container">
         <?php include 'elements/header.php' ?>
         <?php include 'elements/sidebar.php' ?>

         <div class="page-content">
            <div class="main-wrapper">
               <?=$template['body']?>
            </div>
         </div>
      </div>
      <div id="modal-ajax" class="modal fade" ></div>
      
      <!-- Javascripts -->
      <?php include 'elements/script.php'; ?>
   </body>
</html>