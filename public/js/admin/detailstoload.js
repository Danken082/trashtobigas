$(document).ready(function(){
    function loadThisData(){
        $.ajax({
            url:"<?= base_url('')?>",
            type: "GET",
            dataType: "json",
            success: function(response)
            {
                let thisdata = '';
                $.each(response, function(index, admin){
                    thisdata += ``;
            
                });

                $('').html(thisdata);
            }
        });
    }
    loadThisData();
    function convertPoints() {
        let weight = $("#trashWeight").val();
        if (weight <= 0) {
          alert("Please enter a valid trash weight!");
          return;
        }
        $.ajax({
          url: "<?= base_url('convert-trash/' . $details['id']) ?>",
          type: "POST",  
          data: { trashWeight: weight },
          success: function(response) {
            if (response.status === "success") {
              $("#conversionResult").html(`You earned <strong>${response.points}</strong> points, which equals <strong>${response.riceKilos}</strong> kilo/s of rice!`);

             
              loadThisData();
            } else {
              $("#conversionResult").html(`<span style="color: red;">${response.message}</span>`);
            }
          },
          error: function() {
            $("#conversionResult").html(`<span style="color: red;">Error processing request.</span>`);
          }
        });
      }
});