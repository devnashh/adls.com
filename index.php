<div class="container alert alert-default" style="background:#fff">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger" style="background:#2ecc71;border:none;color:#fff">
                <h1>Online Booking System</h1>
            </div>
            <div id="calendar"></div>
        </div>
    </div>
</div>

<script>
    function loadCalendar(month, year) {
        $.ajax({
            url: 'calendar.php',
            type: 'POST',
            data: {month: month, year: year},
            success: function(data) {
                $('#calendar').html(data);
            }
        });
    }

    $(document).ready(function() {
        var date = new Date();
        loadCalendar(date.getMonth() + 1, date.getFullYear());
    });
</script>
