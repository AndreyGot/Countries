// alert('web');

// jQuery.noConflict();
// (function($){ 
//     alert('web');
// })(jQuery);


 jQuery.ajax({
            type: "GET",
            dataType: 'json',
            url: "http://test/app_dev.php/country",
            success: function (jsondata) {
                

$("a[id='title']").append($("<p>"+jsondata[1].title+"</p>"));
                // var data = $.parseJSON(jsondata);
                console.log(jsondata[0].title);
                console.log(jsondata[1].title);
                // $("a[id='title']").append($("<p>"+data[1].title+"</p>"));
            }
        }); 