// 1.為checkbox設置監聽者(批次刪除)
// 獲取DOM元素(注意getElementsByName產生的結果為Nodelist)
const iconDel = document.querySelector("#iconDel");
const recyNodeList = document.getElementsByName("recyChk[]");
const iconDelHtml = iconDel.innerHTML;

console.log(recyNodeList);

// 準備暫存陣列以及切割段落
let recyChkArr = [];
const recyPart1 = iconDelHtml.substr(0, 25);
const recyPart2 = iconDelHtml.substr(-41);

console.log(recyPart1);
console.log(recyPart2);

// 2.監聽者的內容追加功能(批次還原)
// 獲取DOM元素
const iconUndo = document.querySelector("#iconUndo");
const iconUndoHtml = iconUndo.innerHTML;
// 準備切割段落
const undoPart1 = iconUndoHtml.substr(0, 26);
const undoPart2 = iconUndoHtml.substr(-33);

console.log(undoPart1);
console.log(undoPart2);

// 為每個checkbox掛上事件監聽者(目前只有用foreach成功過)
// 刪除和還原共用
recyNodeList.forEach((el) => {
  el.addEventListener("click", () => {
    // 取得按鍵觸發的id資訊
    let nowId = el.value;
    if (document.getElementById(`${nowId}`).checked) {
      recyChkArr.push(nowId);
      iconDel.innerHTML =
        recyPart1 + "?chkIds=" + recyChkArr.join() + recyPart2;
      console.log(iconDel.innerHTML);

      // 還原的部分
      iconUndo.innerHTML =
        undoPart1 + "?chkIds=" + recyChkArr.join() + undoPart2;
      console.log(iconUndo.innerHTML);
    } else {
      recyChkArr = recyChkArr.filter((v) => v !== nowId);
      iconDel.innerHTML =
        recyPart1 + "?chkIds=" + recyChkArr.join() + recyPart2;
      console.log(iconDel.innerHTML);

      // 還原的部分
      iconUndo.innerHTML =
        undoPart1 + "?chkIds=" + recyChkArr.join() + undoPart2;
      console.log(iconUndo.innerHTML);
    }
  });
});
