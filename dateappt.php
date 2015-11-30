 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script>
 $(function() {
     $( "#myTextField" ).datepicker({
        onClose: function(){
            validate($(this).val());
         }
     });
     
  function validate(dateText){
         try {
            alert("You selected is : "+ $.datepicker.parseDate('mm/dd/yy',dateText));
          } catch (e) {
             alert("invalid date");
          }; 
    }
  });

</script>

<p>Date: <input type="text" id="myTextField"></p>
    