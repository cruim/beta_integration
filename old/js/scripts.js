


var r = [];
for (var i = 0; i < 4; i++) {
	r[i] = Math.floor(Math.random() * (255 - 0 + 1)) + 0;
}

var l0 = new Array('0','1','2','3','4','5','6','7','8','9','.')
var l1 = new Array('A','B','C','D','E','F','G','H','I','J','K');
var l2 = new Array('L','M','N','O','P','Q','R','S','T','U','V');
var l3 = new Array('W','X','Y','Z','0','1','2','3','4','5','6');
var l4 = new Array('7','8','9','a','b','c','d','e','f','g','h');
var l5 = new Array('i','j','k','l','m','n','o','p','q','r','s');
var l6 = new Array('t','u','v','w','x','y','z','$','*','@','&');

var a = new Array(l0, l1, l2, l3, l4, l5, l6);


var d = new Date();
var result = leadZero(d.getDate()) + '.' + leadZero((d.getMonth()+1)) + '.' + d.getFullYear();
for (var i = 0; i < 4; i++) {
	result = SH(result, r[i]);
}
var z = Math.random().toString(36).substr(2, 5);
Cookies.set('z', result, {path:'/az'});


function SH(s,c) {
	var result = '';
	for (var i = 0; i < s.length; i++) {
		
		position = 0;
		for (var j = 0; j < a[0].length; j++) {
			if (a[0][j] == s[i]) {
				position = j;
				break;
			}
		}
		
		var rnd = RND(1,6);
//		result = result + String.fromCharCode(s.charCodeAt(i) ^ c);
		result = result + a[rnd][position];
	}
	result = a[RND(1,6)][RND(0,10)] + a[RND(1,6)][RND(0,10)] + result + a[RND(1,6)][RND(0,10)] + a[RND(1,6)][RND(0,10)];
	return result;
}

function leadZero(num) {
	return ('0'+num).slice(-2);
}


function RND(min, max) {
	return Math.floor(Math.random() * (max - min + 1)) + min;
}