/*==================================================
Topページ、ダウンロードページ
===================================*/
if(document.body.classList.contains('index-body') || document.body.classList.contains('dl-body')) {

	// Topページ背景処理
	particlesJS("particles-js",{
		"particles":{
			"number":{
				"value":38,//この数値を変更すると幾何学模様の数が増減できる
				"density":{
					"enable":true,
					"value_area":800
				}
			},
			"color":{
				"value":"#ffffff"//色
			},
			"shape":{
				"type":"polygon",//形状はpolygonを指定
				"stroke":{
					"width":0,
				},
		"polygon":{
			"nb_sides":3//多角形の角の数
		},
		"image":{
			"width":190,
			"height":100
		}
		},
			"opacity":{
			"value":0.664994832269074,
			"random":false,
			"anim":{
				"enable":true,
				"speed":2.2722661797524872,
				"opacity_min":0.08115236356258881,
				"sync":false
			}
			},
			"size":{
				"value":3,
				"random":true,
				"anim":{
					"enable":false,
					"speed":40,
					"size_min":0.1,
					"sync":false
				}
			},
			"line_linked":{
				"enable":true,
				"distance":150,
				"color":"#ffffff",
				"opacity":0.6,
				"width":1
			},
			"move":{
				"enable":true,
				"speed":6,//この数値を小さくするとゆっくりな動きになる
				"direction":"none",//方向指定なし
				"random":false,//動きはランダムにしない
				"straight":false,//動きをとどめない
				"out_mode":"out",//画面の外に出るように描写
				"bounce":false,//跳ね返りなし
				"attract":{
					"enable":false,
					"rotateX":600,
					"rotateY":961.4383117143238
				}
			}
		},
		"interactivity":{
			"detect_on":"canvas",
			"events":{
				"onhover":{
					"enable":false,
					"mode":"repulse"
				},
		"onclick":{
			"enable":false
		},
		"resize":true
			}
		},
		"retina_detect":true
	});
}



/*==================================================
uploadページ
===================================*/
if (document.querySelector('.up-wrapper')) {
	// コピーボタン
	document.querySelectorAll('[data-copy]').forEach(function(element) {
		element.addEventListener('click', function() {
			const textToCopy = this.previousElementSibling.value;

			navigator.clipboard.writeText(textToCopy)
      .then(() => {
        console.log('Text copied to clipboard');
      })
      .catch(err => {
        console.error('Unable to copy text: ', err);
      });

			const feedback = document.createElement('span');
			feedback.innerText = 'コピーしました';
			feedback.style.position = 'absolute';
			feedback.style.top = '-50px';
			feedback.style.left = '-100px';
			feedback.style.backgroundColor = '#333';
			feedback.style.color = '#fff';
			feedback.style.fontSize = '1.6rem';
			feedback.style.padding = '5px 5px 7px 5px';
			feedback.style.borderRadius = '5px';
			feedback.style.opacity = '0';
			feedback.style.transition = 'opacity 0.5s';
			feedback.style.cursor = 'text';
			this.appendChild(feedback);
			
			setTimeout(function() {
				feedback.style.opacity = '1';
			}, 100);

			setTimeout(function() {
				feedback.style.opacity = '0';
				setTimeout(function() {
					feedback.remove();
				}, 500);
			}, 2000);
		});
	});
}

/*==================================================
全ページ共通　関数
===================================*/
function changeFileSizeUnit(fileSize) {
  const units = ['B', 'KB', 'MB', 'GB', 'TB'];
  let i = 0;

  while (fileSize > 1024 && i < units.length - 1) {
    fileSize /= 1024;
    i++;
  }

  // 小数点以下を2桁に丸める
  return fileSize.toFixed(2) + units[i];
}

function swal2DisplayAlert(title, text, icon, btnText) {
	Swal.fire({
		title: title,
		text: text,
		icon: icon,
		confirmButtonText: btnText,
	});
}

function fileValidation(fileName, fileSize) {
	// 拡張子チェック
	const allowedExtensions = [	// 一般的なファイル拡張子
		'jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg', 
		'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv', 'odt', 'ods', 'odp', 
		'mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv', 'webm', 'mpeg', 
		'mp3', 'wav', 'aac', 'flac', 'ogg', 'm4a', 
		'zip', 'rar', '7z', 'tar', 'gz'
	];
	// ファイル名から末尾の拡張子を切り出し
	const extension = fileName.split('.').pop().toLowerCase();

	if (!allowedExtensions.includes(extension)) {
		swal2DisplayAlert('アップロードエラー', 'このファイル形式は許可されていません。', 'error', 'OK');
		return false;
	}


	// ファイルサイズチェック
	const MAX_FILE_SIZE = 5242880;

	if (fileSize > MAX_FILE_SIZE) {
		swal2DisplayAlert('アップロードエラー', 'ファイルサイズが5MBを超えています。', 'error', 'OK')
		return false;
	}

	return true;
}
