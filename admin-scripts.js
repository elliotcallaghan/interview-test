    var changes = [];
    $("#testQuestions td div").on("focus", function() {
        var triggered = false;
        $(this).data("initialText", $(this).html());
        $("#testQuestions td div").on("blur", function() {
            if ($(this).data("initialText") !== $(this).html() && triggered === false) {
                var heading = $(this).parents('table').find('th').eq($(this).parent('td').index()).html(),
                    position = $(this).parent('td').siblings("th").html(),
                    text = $(this).html();
                for (var i = 0; i < changes.length; i++) {
                    if (changes[i][0] === position && changes[i][1] === heading) {
                        changes.splice(i, 1);
                        break;
                    }
                }
                triggered = true;
                changes.push([position, heading, text]);
                console.log(changes);
            }
        })
    })

    $("#saveQuestions").on("click", function() {
        if (changes.length !== 0) {
            $.ajax({
                type: "POST",
                url: "../wp-admin/admin-ajax.php",
                dataType: "text",
                data: {
                    action: "ec_update_questions",
                    changes: changes
                }
            }).done(function () {
                location.reload();
            }).fail(function () {
                console.log("Fail");
            })
        }
    })
    
    $(".row").on("click", function() {
        $(this).nextUntil(".row").slideToggle("fast");
    })
    
    $("#addQuestion").on("click", function() {
        var questionDetails = [
            parseInt($("#testPosition").val()) + 1,
            $("#question").val(),
            $("#category").val(),
            $("#numOfCorAnswers").val(),
            $("#correctOption").val(),
            $("#option1").val(),
            $("#option2").val(),
            $("#option3").val(),
            $("#option4").val(),
            $("#option5").val(),
            $("#option6").val()
        ];

        if ((questionDetails[0] !== "" && questionDetails[1] !== "" && questionDetails[2] !== "" && questionDetails[3] !== "" && questionDetails[4] !== "" && questionDetails[5] !== "" && questionDetails[6] !== "")) {
            if (questionDetails[4] === questionDetails[5] || questionDetails[4] === questionDetails[6] || questionDetails[4] === questionDetails[7] || questionDetails[4] === questionDetails[8] || questionDetails[4] === questionDetails[9] || questionDetails[4] === questionDetails[10]) {
                $.ajax({
                    type: "POST",
                    url: "../wp-admin/admin-ajax.php",
                    dataType: "text",
                    data: {
                        action: "ec_add_question",
                        questionDetails: questionDetails
                    }
                }).done(function () {
                    $("textarea").empty();
                    $("#addResponse").html("Question successfully added").css("color", "#444");
                }).fail(function () {
                    $("#addResponse").html("Question could not be added").css("color", "red");
                })
            } else {
                $("#addResponse").html("One option has to match the correct answer field").css("color", "red");
            }
        } else {
            $("#addResponse").html("Not all fields filled in").css("color", "red");
        }
    })
    
    $("#removeQuestion").on("click", function() {
        var position = $("#removingQuestion").val();

        if (position !== "") {
            $.ajax({
                type: "POST",
                url: "../wp-admin/admin-ajax.php",
                dataType: "json",
                data: {
                    action: "ec_remove_question",
                    position: position
                }
            }).done(function () {
                $("#removeResponse").html("Question successfully removed").css("color", "#444");
            }).fail(function () {
                $("#removeResponse").html("Question could not be removed").css("color", "red");
            })
        } else {
            $("#removeResponse").html("No question id provided").css("color", "red");
        }
    })
