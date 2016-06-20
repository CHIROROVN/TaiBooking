$(document).ready(function(){
	
});

$('#cus_name_kana').on('change',function(){
  var cnk = $(this).val();
  var url = "enterprise/regist/cnk_ajax";
    $.ajax({
              type: "GET",
              url: url,
              data: {cnk:cnk},
              success: function (data) {
                console.log(data['cnk']);
              },
              error: function (data) {
                  console.log('Error:', data);
              }
      });
  });
