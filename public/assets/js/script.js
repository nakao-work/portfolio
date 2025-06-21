// 年齢と経験年数の計算
function calcYear(date) {
	let today = new Date();
	let targetdate = today.getFullYear() * 10000 + (today.getMonth() + 1) * 100 + today.getDate();
	return (Math.floor((targetdate - date) / 10000));
}
document.getElementById('myAge').textContent = calcYear(19920827);
document.getElementById('elapsedYears').textContent = calcYear(20210517)+1;

// フッター更新年数
document.getElementById("id-year").textContent = new Date().getFullYear();

//　デバック用：クリックされた要素をコンソールに表示
// document.addEventListener("click", function (event) {
// 	const clickedElement = event.target;
// 	console.log("クリックされた要素:", clickedElement);
// });

//　デバック用：特定の要素がクリックされたかコンソールに表示
// document.querySelector(".modal__overlay").addEventListener("click", function(event) {
// 	console.log("オーバーレイがクリックされました", event.target);
// });