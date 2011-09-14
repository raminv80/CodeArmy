/*
$(document).ready(function() {

$('.details').hide();

$('.item').click(function() {
	$(this).toggleClass('.details').next().slideToggle("slow");
	$(this).addClass('selected').siblings('.item').removeClass();
	return false;
});
*/


/*

$(document).ready(function() {

$("#myTable tr:odd").addClass("master");
$("#myTable tr:not(.master)").hide();
$("#myTable tr:first-child").show();
$("#myTable tr.master").click(function(){
    $(this).next("tr").toggle();
    $(this).find(".arrow").toggleClass("up");
});


    $("#myTable tr:odd").addClass("odd");
    $("#myTable tr:not(.odd)").hide();
    $("#myTable tr:first-child").show();
            
    $("#myTable tr.odd").click(function(){
          $(this).next("tr").toggle();
          $(this).find(".arrow").toggleClass("up");
    });
            //$("#myTable").jExpand();
});

*/

$(document).ready(function(){
            //$("tr:details").addClass("details");
            $(".myTable tr:not(.story-title)").hide();
            $(".myTable tr:first-child").show();
            
            $(".myTable tr.story-title").click(function(){
                $(this).next("tr").toggle();
                $(this).find(".arrow").toggleClass("up");
            });
            //$("#myTable").jExpand();
});

$(document).ready(function(){
            //$("tr:details").addClass("details");
            $(".myTable1 tr:not(.story-title1)").hide();
            $(".myTable1 tr:first-child").show();
            
            $(".myTable1 tr.story-title1").click(function(){
                $(this).next("tr").toggle();
                $(this).find(".arrow").toggleClass("up");
            });
            //$("#myTable").jExpand();
			//if($(".detailbox"))
			$(".detailbox").colorbox({width:"80%", height:"80%"});
});