<script src="<?php echo TEMPLATE_URL; ?>/plugins/fullcalendar/lib/moment.min.js?<?php echo CACHE_VERSION; ?>"></script>
<script src="<?php echo TEMPLATE_URL; ?>/plugins/fullcalendar/lib/jquery-ui.custom.min.js?<?php echo CACHE_VERSION; ?>"></script>
<script src="<?php echo TEMPLATE_URL; ?>/plugins/fullcalendar/fullcalendar.min.js?<?php echo CACHE_VERSION; ?>"></script>
<script src="<?php echo TEMPLATE_URL; ?>/js/demo/misc-fullcalendar.js?<?php echo CACHE_VERSION; ?>"></script>

<script>
    function removeEvent(event) {
        if (confirm('Please confirm delete event topic?')) {
            $('.ac').val('del');
            $('#name').val(event);
            $('#form1').submit();
        } else {
            return false;
        }
    }

    $('#demo-external-events .fc-event').each(function() {
        $(this).data('event', {
            title: $.trim($(this).text()),
            stick: true,
            className: $(this).data('class')
        });
        $(this).draggable({
            zIndex: 99999,
            revert: true,
            revertDuration: 0
        });
    });

    const calendar = $('#demo-calendar');
    calendar.fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        editable: true,
        droppable: true,
        defaultDate: '<?php echo date('Y-M-d', _TIME_); ?>',
        <?php $events = [];
        $ck = read_txt_json(PATH_UPLOAD . '/calendar/date.txt');
        if (!empty($ck)) {
            foreach ($ck as $year => $dates) {
                foreach ($dates as $date => $names) {
                    foreach ($names as $name => $color) {
                        $events[] = [
                            'title' => $name,
                            'start' => $date,
                            'className' => $color,
                            'durationEditable' => false
                        ];
                    }
                }
            }
        } ?>
        events: <?php echo json_encode($events); ?>,
        eventReceive: function(event) {
            event.durationEditable = false;
            var events = calendar.fullCalendar('clientEvents', ev => ev.start.isSame(event.start, 'day'));
            if (events.length > 1) {
                calendar.fullCalendar('removeEvents', event._id);
            } else {
                $.post('doAjax.php?module=calendar&mp=write_receive', {
                    name: event.title,
                    date: event.start.format(),
                    color: event.className[0]
                });
            }
        },
        eventDrop: function(event, delta, revertFunc) {
            var events = calendar.fullCalendar('clientEvents', ev => ev.start.isSame(event.start, 'day'));
            if (events.length > 1) {
                revertFunc();
            } else {
                var oldDate = event.start.clone().subtract(delta);
                $.post('doAjax.php?module=calendar&mp=write_drop', {
                    name: event.title,
                    color: event.className[0],
                    date: event.start.format(),
                    old: oldDate.format()
                });
            }
        },
        eventRender: function(event, element) {
            var content = element.find(".fc-content");
            content.css({
                display: "flex",
                justifyContent: "space-between",
                alignItems: "center"
            });
            content.append("<i class='fa fa-times-circle event-delete' style='cursor: pointer;'></i>");
            element.find(".event-delete").on('click', () => {
                if (confirm("Please confirm delete event?")) {
                    $.post('doAjax.php?module=calendar&mp=remove_event', {
                        date: event.start.format(),
                    }, () => {
                        calendar.fullCalendar('removeEvents', event._id);
                    });
                }
            });
        }
    });
</script>