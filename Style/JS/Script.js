var score = 0;
var level = -1;
var thisisanswer = '';
var numofcard = 0;
var memory_array = [];
var tiles_flipped = 0;
var ANSWER = [];
var TIME = 100;
var lockcard = false;
var lockABCD = false;
var ABCDanswer;
var trueorfalse = false;
var cardtick;
var totallevel;
var go;
var DB = [];
var mainQuest;

Array.prototype.memory_tile_shuffle = function() { //random Array
    var i = this.length,j;
    var temp = {};
    while (--i > 0) {
        j = Math.floor(Math.random() * (i + 1));
        temp = this[j];
        this[j] = this[i];
        this[i] = temp;
    }
}


function timerun() { // time
    document.getElementById('time').innerHTML = TIME;
    go = setTimeout("timerun()", 1000);
    TIME--;
    if (TIME < 0) {
        if (lockABCD === true && lockcard === true) {
            checkanswer();
        } else {
            clearTimeout(go);
            document.getElementById('ABCD').style.visibility = "hidden";
            document.getElementById(ABCDanswer).style.background = 'blue';
            lockABCD = true;
            lockcard = false;
            setTimeout(ABCD_back(), 9000);
            setTimeout(newquest_ABCD_answer(" , , , , , "), 5000);
            document.getElementById('time').innerHTML = " ";
            cardtick.style.background = 'black';           
            if (numofcard == 0) {
                lockcard = true;
                lockABCD = true;
                document.getElementById("question").innerHTML = "Hãy đưa ra câu trả lời (viết liền, chữ thường, không dấu): ";
                TIME = 30;
                setTimeout(timerun, 300);
                var lastquest = document.getElementById('foranswer');
                lastquest.innerHTML = '<div id="youranswer"> <input type="text" id="myanswer"><input type="button" id="checkanswer" value="CHECK" onclick="checkanswer()"></div>';
                lastquest = document.getElementById('youranswer');
                lastquest.style.background = 'transparent';
                lastquest.style.width = '600px';
                lastquest.style.height = '26px';
                lastquest.style.padding = '10px';
                lastquest.style.margin = '20px auto';
                document.getElementById('question').style.background = 'rgba(142,181,242,0.9';
                document.getElementById('question').style.border = 'none';
                document.getElementById('youranswer').style.border = 'none';
                document.getElementById('ABCD').style.visibility = "visible";
            }
        }
    }
}


function newanswer(Answer) { //tạo câu hỏi và câu trả lời
    var output = '';
    var length = 0;
    thisisanswer = Answer;
    length = thisisanswer.length * 35 + 10;
    if (length >= 890) length = 890;
    tile = document.getElementById('answer');
    tile.style.width = length + 'px'; // tính kích thước vùng answer
    var length = Answer.length;
    for (var i = 0; i < length; i++) {
        ANSWER.push(Answer[i]); //array chứa các ký tự
        output += '<div id="answer_' + i + '"></div>'; // tạo các ô chữ
    }
    document.getElementById('answer').innerHTML = output;
}

function readJson() {
    $.getJSON('../../data/Questions_answers.json', function(data) {
        for (var i in data) {
            DB.push(data[i]);
            totallevel = data.length;
        }
    });
}


function newBoard(val) {
    lockcard = false;
    lockABCD = true;
    level += 1;
    score = val;
    document.getElementById("score").innerHTML = "Điểm : " + score;
    DB[level].Questions.memory_tile_shuffle();
    mainQuest = DB[level].TopicQuest;
    numofcard = DB[level].NumOfCard;
    newanswer(DB[level].TopicAnswer);
    document.getElementById('memory_board').style.background = 'url(' + DB[level].NameOfPic + ')';
    document.getElementById('memory_board').style.backgroundSize = 'cover'
    document.getElementById('foranswer').innerHTML = '<div id="A" onclick="checkABCD(\'A\')"></div> <div id="B" onclick="checkABCD(\'B\')"></div><div id="C" onclick="checkABCD(\'C\')"></div><div id="D" onclick="checkABCD(\'D\')"></div>';
    var output = '';
    var sizeofcard = Math.floor(650 / Math.sqrt(numofcard)) - 40 - 4;
    for (var i = 0; i < numofcard; i++) {
        memory_array[i] = " ";
        output += '<div id="tile_' + i + '" style = "height:' + sizeofcard + 'px;width :' + sizeofcard + 'px;" onclick="memoryFlipTile(this,\'' + memory_array[i] + '\')">' + i + '</div>';
    }
    document.getElementById("level").innerHTML = "Level : " + (level + 1);
    document.getElementById("mainQuest").innerHTML = "Câu hỏi chính :" + (mainQuest);
    document.getElementById('memory_board').innerHTML = output;
}


function checkanswer() { // kiểm tra câu trả lời
    var Myanswer = document.getElementById('myanswer').value;
    document.getElementById('ABCD').style.visibility = "hidden";
    clearTimeout(go);
    for (var i = 0; i < memory_array.length; i++) { // hiển thị card
        var tile = document.getElementById('tile_' + i);
        tile.style.background = 'transparent';
    }
    for (var i = 0; i < thisisanswer.length; i++) { // hiểnn thị answer
        var tile = document.getElementById('answer_' + i);
        tile.innerHTML = thisisanswer[i];
    }

    if (Myanswer === thisisanswer) {
        score += TIME;
        document.getElementById("memory_board").innerHTML = ' <span id="StartorNext" onclick="newBoard(' + score + ')"> NEXT LEVEL </span>';
        for (var i = 0; i < thisisanswer.length; i++) { // hiển thị answer
            var tile = document.getElementById('answer_' + i);
            tile.style.background = 'blue';
        }
    } else {
        document.getElementById("memory_board").innerHTML = ' <span id="StartorNext" onclick="newBoard(' + 0 + ')"> GAME OVER RESTART </span>';
        level = -1;
        for (var i = 0; i < thisisanswer.length; i++) { // hiển thị answer
            var tile = document.getElementById('answer_' + i);
            tile.style.background = 'red';
        }
    }
    document.getElementById("score").innerHTML = "Điểm : " + score;

    if (totallevel - 1 == level) {
        level = -1;
        document.getElementById("memory_board").innerHTML = ' <span id="StartorNext" onclick="newBoard(' + 0 + ')"> GAME CLEAR RESTART</span>';
    }
}


function ABCD_back() {
    document.getElementById('A').style.background = 'rgba(142,181,242,0.9)';
    document.getElementById('B').style.background = 'rgba(142,181,242,0.9)';
    document.getElementById('C').style.background = 'rgba(142,181,242,0.9)';
    document.getElementById('D').style.background = 'rgba(142,181,242,0.9)';
}



function newquest_ABCD_answer() {
    document.getElementById('question').innerHTML = DB[level].Questions[numofcard].quest;
    document.getElementById('A').innerHTML = DB[level].Questions[numofcard].A;
    document.getElementById('B').innerHTML = DB[level].Questions[numofcard].B;
    document.getElementById('C').innerHTML = DB[level].Questions[numofcard].C;
    document.getElementById('D').innerHTML = DB[level].Questions[numofcard].D;
    ABCDanswer = DB[level].Questions[numofcard].answer;
}



function checkABCD(ABCD) {

    if (lockABCD === false) {
        clearTimeout(go);
        lockABCD = true;
        var tile = document.getElementById(ABCD);
        tile.style.background = 'yellow';

        function giveanswer() {
            document.getElementById(ABCDanswer).style.background = "blue";
            if (ABCD === ABCDanswer) {
                trueorfalse = true;

                if (TIME < 0) TIME = 0;
                score += TIME + 1;
                document.getElementById("score").innerHTML = "Điểm : " + score;
            } else {
                tile.style.background = "red";
                trueorfalse = false;
            }
        }

        function onpenorclose() {
            if (trueorfalse === true) {
                cardtick.style.background = 'transparent';
            } else {
                cardtick.style.background = 'black';

            }

        }

        setTimeout(giveanswer(), 2000)
        setTimeout(onpenorclose(), 9000);
        document.getElementById('ABCD').style.visibility = "hidden";
        setTimeout(ABCD_back(), 9000);
        setTimeout(newquest_ABCD_answer(" , , , , , "), 5000);
        document.getElementById('time').innerHTML = " ";
        document.getElementById('ABCD').style.visibility = "hidden";
        lockcard = false;

        if (numofcard == 0) {
            lockcard = true;
            lockABCD = true;
            document.getElementById("question").innerHTML = "Hãy đưa ra câu trả lời (viết liền, chữ thường, không dấu): ";
            TIME = 30;
            setTimeout(timerun, 300);
            var lastquest = document.getElementById('foranswer');
            lastquest.innerHTML = '<div id="youranswer"> <input type="text" id="myanswer"><input type="button" id="checkanswer" value="CHECK" onclick="checkanswer()"></div>';
            lastquest = document.getElementById('youranswer');
            lastquest.style.background = 'transparent';
            lastquest.style.width = '600px';
            lastquest.style.height = '26px';
            lastquest.style.padding = '10px';
            lastquest.style.margin = '20px auto';
            document.getElementById('question').style.background = 'rgba(142,181,242,0.9';
            document.getElementById('question').style.border = 'none';
            document.getElementById('youranswer').style.border = 'none';
            document.getElementById('ABCD').style.visibility = "visible";
        }
    }
}


function memoryFlipTile(tile, val) {
    if (lockcard === false && tile.innerHTML != " ") {
        numofcard -= 1;
        document.getElementById('ABCD').style.visibility = "visible";
        tile.innerHTML = " ";
        cardtick = tile;
        TIME = 30;
        setTimeout(timerun(), 100);
        lockcard = true;
        lockABCD = false;
        tile.style.background = 'yellow'; 
        newquest_ABCD_answer();
    }
}