// add word
// タグのリストをクリックする、テキストボックスへ単語を追加
Array.prototype.contains = function (ele) {
	for (var i = 0; i < this.length; i++) {
		if (this[i] == ele) {
			return true;
		}
	}
	return false;
};

// remove word
// タグのリストをクリックすると、テキストボックスの単語を取り除く
Array.prototype.remove = function (ele) {
	var arr = new Array();
	var count = 0;
	for (var i = 0; i < this.length; i++) {
		if (this[i] != ele) {
			arr[count] = this[i];
			count++;
		}
	}
	return arr;
};

// add tag
// 単語を並べる
// タグのリスト
function addTag(ele) {
	var thisTag = ele.innerHTML;
	var taglist = document.getElementById('tags');
	var tags = taglist.value.split(', ');
	
	// If tag is already listed, remove it
	if (tags.contains(thisTag)) {
		tags = tags.remove(thisTag);
		ele.className = 'unselected';
		
	// Otherwise add it
	} else {
		tags.splice(0, 0, thisTag);
		ele.className = 'selected';
	}
	
	taglist.value = tags.join(', ');
	
	document.getElementById('tags').focus();
};

// 初期設定
// body内のタグリストを取得
function addition() {
		var taglist = document.getElementById('tags');
		var tags = taglist.value.split(', ');
		var populartags = document.getElementById('popularTags').getElementsByTagName('span');
		for (var i = 0; i < populartags.length; i++) {
			if (tags.contains(populartags[i].innerHTML)) {
				populartags[i].className = 'selected';
			}
		}
};

// Onload を使わずに処理する
// arrange for our onload handler to "listen" for onload events
if (window.attachEvent) {
	// Internet Explorer;
	window.attachEvent("onload", function() {
	  addition();
	});
} else {
	// Firefox and standard browsers
	window.addEventListener("load", function() {
		addition();
	}, false);
};
