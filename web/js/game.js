$(function(){
    var url = Routing.generate('play');

    $(".board").on("click", ".field:not(.disabled)", function(){
        if($(this).hasClass("occupied")) return;

        $(this)
            .text("x")
            .addClass("occupied");

        $(".field").each(function(){
           $(this).addClass("disabled");
        });

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
                    window.location.replace(Routing.generate('over', {winner: result["winner"]}));
                }
                $(".field").each(function(){
                    $(this).removeClass("disabled");
                });
            }
        })
    });
});