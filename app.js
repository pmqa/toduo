jQuery(function ($) {

    var App = {

        init: function () {
            App.initCalendar();
            App.bind();
        },

        initCalendar: function () {

            //populate calendar
            $.getJSON('http://localhost/toduo/calendar.php', function (data) {
                $.each(data, function (index, value) {
                    
                    index++;
                    var week = '<div class="week-nav" id="week-' + index + '">' +
                        '<h1>Week ' + index + ', January 2016</h1>'+
                        '</div>';

                    $('.weeks-container').append(week);

                });
                
             App.showWeek(1);    
            });
        
        },

        showWeek: function (w) {
            
            // display current week
            
            App.currentWeek = w;
            var $week = $('.weeks-container #week-' + w);
            
            // hide all weeks
            $('.weeks-container .week-nav').hide();
            
            $week.show();            
            App.showWeeksData(w);
            
        },

        currentWeek: 1,
        
        showWeeksData: function(w) {
            
            var $weekdays = $('.weekdays .weekday');            
            $weekdays.find('.todo-list').empty();
            
            $.getJSON('http://localhost/toduo/api.php?get_week='+w+'&key=peteralmeida', function (data) {     

                $.each(data, function(index,value){
                    if (data[index].eventos.length > 0) {                        
                
                        for (var i = 0; i < data[index].eventos.length; i++) {
                            $weekdays.eq(index-1).find('.todo-list').append('<li>'+data[index].eventos[i]+'</li>');
                        };
                    }
                });
                
            });
            
        },

        bind: function () {

            //bind event
            $('.new-todo').keypress(function (event) {
                if (event.keyCode == 13) {
                    App.render($(this).parent(), $(this).val());
                    $(this).val('');
                    return false;
                }
            });

            //next and prev    
            $('.next').click(function(){
                App.showWeek(App.currentWeek+1); 
                                
            });
            
            //next and prev    
            $('.prev').click(function(){
                App.showWeek(App.currentWeek-1); 

            });

        },

        render: function (parent, elem) {
            $(parent).find('.todo-list').append('<li>' + elem + '</li>');

        }

    };

    App.init();
});