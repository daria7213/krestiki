$(function(){
    var url = Routing.generate('play');
    var fields = $(".field");

    $(".board").on("click", ".field:not(.disabled)", function(){
        if($(this).hasClass("occupied")) return;

        $(this)
            .text("x")
            .addClass("occupied");

        fields.each(function(){
           $(this).addClass("disabled");
        });

        var board = [];
        fields.each(function(){
            var value = $(this).text().trim();
            board.push(value == "" ? 'e' : value);
        });

        $.ajax({
            url: url,
            method: "POST",
            data: {board: board},
            success: function(result){
                fields.each(function(){
                    var value = result["board"][$(this).data("index")];

                    if(value == 'e'){
                        value = "";
                    } else {
                        $(this).addClass("occupied");
                    }
                    $(this).text(value);
                });
                if(result["winner"]){
                    var time = result["winner"] == "o" ? 800 : 200;
                    setTimeout(function(){
                        window.location.replace(Routing.generate('over', {winner: result["winner"]}));
                        fields.each(function(){
                            $(this).removeClass("disabled");
                        });
                    }, time);
                } else {
                    fields.each(function(){
                        $(this).removeClass("disabled");
                    });
                }
            }
        })
    });
});