$(function(){
    var url = Routing.generate('play');

    $(".field").click(function(){
        if($(this).hasClass("occupied")) return;

        $(this)
            .text("x")
            .addClass("occupied");

        var board = [];
        $(".field").each(function(){
            var value = $(this).text().trim();
            board.push(value == "" ? 'e' : value);
        });
        $.ajax({
            url: url,
            method: "POST",
            data: {board: board},
            success: function(result){
                $(".field").each(function(){
                    var value = result["board"][$(this).data("index")];

                    if(value == 'e'){
                        value = "";
                    } else {
                        $(this).addClass("occupied");
                    }
                    $(this).text(value);
                });
                if(result["winner"]){
                    setTimeout(function(){
                        window.location.replace(Routing.generate('over', {winner: result["winner"]}));
                    }, 500);

                }
            }
        })
    });
});