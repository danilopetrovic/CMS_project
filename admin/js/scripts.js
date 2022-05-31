/**
 * Created by Danilo on 28-Jun-17.
 */

/*jquery za checkbox u view all posts da moze sve da se brise ili publishuje ili draftuje...*/
$(document).ready(function () {
    /*selektovanje i deselektovanje svega sa checkbox*/
    $('#selectAllBoxes').click(function (event) {
        if(this.checked) {
            $('.checkBoxes').each(function () {
                this.checked = true;
            });
        }
        else {
            $('.checkBoxes').each(function () {
                this.checked = false;
            });
        }
    });

    /*loader slicica dok ucitava*/
    var div_box = "<div id='load-screen'><div id='loading'></div></div>";
    $("body").prepend(div_box);
    $('#load-screen').delay(100).fadeOut(100,function () {
        $(this).remove();
    });

    /*online users*/
    function loadUsersOnline() {
        $.get("functions.php?onlineusers=response", function(data) {
            $(".usersOnline").text(data);
        });
    }
    setInterval(function () {
        loadUsersOnline();
    },3000);

    /*za delete_modal*/
    $(".delete_link").on('click', function () {
        var id = $(this).attr("rel");
        var delete_url = "posts.php?delete=" + id;
        $(".modal_delete_link").attr("href", delete_url);
        $("#myModal").modal('show');
        // alert(delete_url);
    });
});
