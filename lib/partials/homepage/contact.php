<?php
$out .= '
<a class="anchor" id="contact"></a>
<section class="contact container-fluid">
    <div class="container">
    <div class="row g-0 sent-thanks alert alert-success">
    <div class="col-lg-4 offset-lg-4">
        <h2 class="display-1"><strong>Thank you for your message!</strong></h2>
    </div>
    <div class="col-lg-2 svg-icon--title" style="
                    background-image: url(/app/themes/helios/dist/homepage/icons/mail.svg);
                  ">
    </div>
    </div>';
$out .= do_shortcode('[contact-form-7 id="e7d6778" title="Contact"]');

$out .= '<div class="wpcf7-spinner-wrapper"><div class="wpcf7-spinner">
</div>
</div>
</section>';
//     <form action="/contact/" autocomplete="on" method="post">
//       <div class="row">
//         <div class="form-group">
//             <h1 class="contact-title">Contact Us</h1>
//             <hr>
//         </div>
//         <div class="col-lg-6">
//             <div class="wrap-label">
//                <label for="name">First Name</label>
//                <i class="fa fa-pencil fa-3x iconicfill-pen-alt2"></i>
//             </div>
//             <input type="text" id="name" placeholder="First Name" class="form-control">
//         </div>
//         <div class="col-lg-6">
//           <div class="wrap-label">
//             <label for="lname">Last Name </label>
//             <i class="fa fa-pencil fa-3x iconicfill-pen-alt2"></i>
//           </div>
//             <input type="text" placeholder="Last Name" id="lname" class="form-control">
//         </div>
//       </div>
//       <div class="row">
//         <div class="col-lg-6">
//           <div class="wrap-label">
//             <label for="email">Email</label>
//             <i class="fa fa-pencil fa-3x iconicfill-pen-alt2"></i>
//           </div>
//           <input type="text" placeholder="example@email.com" id="email" class="form-control">
//         </div>
      
//           <div class="col-lg-6">
//             <div class="wrap-label">
//               <label for="pnumber">Phone Number</label>
//               <i class="fa fa-pencil fa-3x iconicfill-pen-alt2"></i>
//             </div>
//               <input type="text" placeholder="xxx-xxx-xxxx" id="pnumber" class="form-control">
//           </div>
    
//       </div>
//       <div class="row">
//         <div class="col-lg-6">
//           <label>Your Message</label>
//             <textarea placeholder="Your Message" rows="7" class="form-control"></textarea>
          
//         </div>
//       </div>
//        <div class="row">
    
//           <div class="col text-center mt-5">
//              <button type="submit" class="home-button xwide-button grey-button">Submit</button>
//           </div>
//       </div>
//     </form>
//     </div>
//  </section>';
