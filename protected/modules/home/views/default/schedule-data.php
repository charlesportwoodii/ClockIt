<script>

function cleanSpaces(text) {
          var returnText = "";
          for(var i = 0; i < text.length; i++) {
                  if(text[i] != ' ')
                          returnText += text[i];
          }
          return returnText;
  }


$(document).ready(function() {


   var $calendar = $('#calendar');
   var id = 10;

   $calendar.weekCalendar({
      displayOddEven:true,
      timeslotsPerHour : 4,
      allowCalEventOverlap : true,
      overlapEventsSeparate: true,
      firstDayOfWeek : 1,
      businessHours :{start: 6, end: 24, limitDisplay: true },
      daysToShow : 7,
      switchDisplay: {'Day': 1, 'Three Day': 3, 'Work Week': 5, 'Full Week': 7},
	  readonly: true,
	  useShortDayNames: true,
	  dateFormat: "n/j",
	  headerSeparator: " ",
	  allowEventCreation: false,
        draggable: function(calEvent, element) {
          return false;
        },
        resizable: function(calEvent, element) {
          return true;
        },
      title: function(daysToShow) {
			return daysToShow == 1 ? '%date%' : '%start% - %end%';
      },
      height : function($calendar) {
         return $(window).height() - $("h1").outerHeight() - 1;
      },
      eventRender : function(calEvent, $event) {
	$event.addClass(cleanSpaces(calEvent.title));
      },
      eventClick : function(calEvent, $event) {

         if (calEvent.title != "Clocked Time") {
            return;
         }

         var $dialogContent = $("#event_edit_container");
         resetForm($dialogContent);
         var startField   = $dialogContent.find("select[name='start']").val(calEvent.start);
         var endField     = $dialogContent.find("select[name='end']").val(calEvent.end);
		 var type2 		  = $dialogContent.find("input[name='Forgot[type]']").val('1');
         var typeField    = $("input[name='Forgot[type]']:checked");
         var commentField = $("textarea[name='Forgot_comments']");

         $dialogContent.dialog({
            modal: true,
            title: "Submit a Forgotten Shift Notice",
            close: function() {
               $dialogContent.dialog("destroy");
               $dialogContent.hide();
            },
            buttons: {
               save : function() {
					// For some stupid reason we need to refresh our data TWICE to actually capture it
					
					typeField = $("input[name='Forgot[type]']:checked");
					typeField = $("input[name='Forgot[type]']:checked");
					
					// Store in data vars
					var start = startField.val();
					var end = endField.val();
					var type = typeField.attr('id').replace("Forgot_type_","");
					if (type == "0")
						type = 3;
					var comment = commentField.val();
					var asid = calEvent.id;
					var loadingForm = '<div id="loading"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/load-circleBlock.gif" /><p>Please wait while ClockIt processes your request</p></div>';
					
					if(start == "" || end == "" || type == "" || comment == "") {
						$("#punchBox").bPopup({modalClose: false, escClose: false, vStart: 350});
						$("#loading").replaceWith("<div id=\"loading\"><strong>All fields are required. Please do not continue until you have filled in all parts of the form.</strong></div>");
						setTimeout(function(){$("#punchBox").bPopup().close()},6000);						
						setTimeout(function(){$("#loading").replaceWith(loadingForm)},6250);
						}
					else {
					  // Ajax Callback to update our form
					  $.ajax({
						url: 'forgotHelper',
						type: 'POST',
						data: {"Forgot[asid]": asid, "Forgot[start]": start, "Forgot[end]": end, "Forgot[type]": type, "Forgot[comment]": comment},
						beforeSend: function() {
							$("#punchBox").bPopup({modalClose: false, escClose: false, vStart: 350});
							},
						success: function(data) {
							// Close our Dialog box if successful, otherwise we need to keep it open
							$("#loading").replaceWith("<div id=\"loading\"><strong>" + data + "</strong></div>");
							$dialogContent.dialog("close");
							},
						error: function(data) {
							// Yii error ouput for errors
							$("#loading").replaceWith(data);
							},
						complete: function() {
							setTimeout(function(){$("#punchBox").bPopup().close()},6000);						
							setTimeout(function(){$("#loading").replaceWith(loadingForm)},6250);
							}
						});
					}
               },
               cancel : function() {
                  $dialogContent.dialog("close");
               }
            }
         }).show();

         var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
         $dialogContent.find(".date_holder").text($calendar.weekCalendar("formatDate", calEvent.start));
         setupStartAndEndTimeFields(startField, endField, calEvent, $calendar.weekCalendar("getTimeslotTimes", calEvent.start));
         $(window).resize().resize(); //fixes a bug in modal overlay size ??

      },
      noEvents : function() {
      },
      data : "<? echo Yii::app()->baseUrl; ?>/home/scheduledShifts",
   });

   function resetForm($dialogContent) {
      $dialogContent.find("input").val("");
      $dialogContent.find("textarea").val("");
   }
   
	function resetForm($dialogContent) {
      $dialogContent.find("input").val("");
      $dialogContent.find("textarea").val("");
   }
   /*
    * Sets up the start and end time fields in the calendar event
    * form for editing based on the calendar event being edited
    */
   function setupStartAndEndTimeFields($startTimeField, $endTimeField, calEvent, timeslotTimes) {

      $startTimeField.empty();
      $endTimeField.empty();

      for (var i = 0; i < timeslotTimes.length; i++) {
         var startTime = timeslotTimes[i].start;
         var endTime = timeslotTimes[i].end;
         var startSelected = "";
         if (startTime.getTime() === calEvent.start.getTime()) {
            startSelected = "selected=\"selected\"";
         }
         var endSelected = "";
         if (endTime.getTime() === calEvent.end.getTime()) {
            endSelected = "selected=\"selected\"";
         }
         $startTimeField.append("<option value=\"" + startTime + "\" " + startSelected + ">" + timeslotTimes[i].startFormatted + "</option>");
         $endTimeField.append("<option value=\"" + endTime + "\" " + endSelected + ">" + timeslotTimes[i].endFormatted + "</option>");

         $timestampsOfOptions.start[timeslotTimes[i].startFormatted] = startTime.getTime();
         $timestampsOfOptions.end[timeslotTimes[i].endFormatted] = endTime.getTime();

      }
      $endTimeOptions = $endTimeField.find("option");
      $startTimeField.trigger("change");
   }

   var $endTimeField = $("select[name='end']");
   var $endTimeOptions = $endTimeField.find("option");
   var $timestampsOfOptions = {start:[],end:[]};

   //reduces the end time options to be only after the start time options.
   $("select[name='start']").change(function() {
      var startTime = $timestampsOfOptions.start[$(this).find(":selected").text()];
      var currentEndTime = $endTimeField.find("option:selected").val();
      $endTimeField.html(
            $endTimeOptions.filter(function() {
               return startTime < $timestampsOfOptions.end[$(this).text()];
            })
            );

      var endTimeSelected = false;
      $endTimeField.find("option").each(function() {
         if ($(this).val() === currentEndTime) {
            $(this).attr("selected", "selected");
            endTimeSelected = true;
            return false;
         }
      });

      if (!endTimeSelected) {
         //automatically select an end date 2 slots away.
         $endTimeField.find("option:eq(1)").attr("selected", "selected");
      }

   });


});
</script>
