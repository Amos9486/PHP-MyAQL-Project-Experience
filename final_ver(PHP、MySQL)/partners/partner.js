// 0.設置通用的時間物件變數
let expTime = new Date();

// 1.為checkbox設置監聽者(批次刪除，功能移動至垃圾桶頁面)

// 2.為下拉選單設置監聽者(應用於設置每頁顯示數量)
// 獲取DOM元素
const choosePage = document.querySelector("#choosePage");

// 設置事件監聽者，將資料轉存到cookie
choosePage.addEventListener("change", () => {
  expTime.setTime(expTime.getTime() + 60 * 60 * 1000);
  document.cookie = `choosePage=${
    choosePage.value
  }; expires=${expTime.toGMTString()};`;
  console.log(document.cookie);
  // 常用方法有三：.reload()、.replace()、.herf=
  // 用法相似，但有小差異，在實作上要確認
  window.location.replace("./partner.php");
});

// 3.傳回原畫面的搜尋
// 獲取DOM元素
const textFind = document.querySelector("#textFind");
const iconFind = document.querySelector("#iconFind");

// 為搜尋的input設置事件監聽者
iconFind.addEventListener("click", () => {
  expTime.setTime(expTime.getTime() + 60 * 60 * 1000);
  document.cookie = `findKey=${
    textFind.value
  }; expires=${expTime.toGMTString()};`;
  console.log(document.cookie);
  window.location.replace(`./partner.php`);
});

// 4.傳回原畫面的排序
// 獲取DOM元素
const orderCol = document.querySelector("#orderCol");
const orderType = document.querySelector("#orderType");

// 為兩個下拉選單設置事件監聽者(cookie要分開設置)
orderCol.addEventListener("change", () => {
  if (orderCol.value !== "" && orderType.value !== "") {
    expTime.setTime(expTime.getTime() + 60 * 60 * 1000);
    document.cookie = `orderCol=${
      orderCol.value
    }; expires=${expTime.toGMTString()};`;
    document.cookie = `orderType=${
      orderType.value
    }; expires=${expTime.toGMTString()};`;
    console.log(document.cookie);
    window.location.replace(`./partner.php`);
  }
});
orderType.addEventListener("change", () => {
  if (orderCol.value !== "" && orderType.value !== "") {
    expTime.setTime(expTime.getTime() + 60 * 60 * 1000);
    document.cookie = `orderCol=${
      orderCol.value
    }; expires=${expTime.toGMTString()};`;
    document.cookie = `orderType=${
      orderType.value
    }; expires=${expTime.toGMTString()};`;
    console.log(document.cookie);
    window.location.replace(`./partner.php`);
  }
});

// 5.為checkbox設置監聽者(丟到垃圾桶)
// 獲取DOM元素(注意getElementsByName產生的結果為Nodelist)
const iconRecy = document.querySelector("#iconRecy");
const partnerNodeList = document.getElementsByName("partnerChk[]");
const iconRecyHtml = iconRecy.innerHTML;

console.log(partnerNodeList);

// 準備暫存陣列以及切割段落
let partnerChkArr = [];
const partnerPart1 = iconRecyHtml.substr(0, 26);
const partnerPart2 = iconRecyHtml.substr(-38);

console.log(partnerPart1);
console.log(partnerPart2);

// 為每個checkbox掛上事件監聽者(目前只有用foreach成功過)
partnerNodeList.forEach((el) => {
  el.addEventListener("click", () => {
    // 取得按鍵觸發的id資訊
    let nowId = el.value;
    if (document.getElementById(`${nowId}`).checked) {
      partnerChkArr.push(nowId);
      iconRecy.innerHTML =
        partnerPart1 + "?chkIds=" + partnerChkArr.join() + partnerPart2;
      console.log(iconRecy.innerHTML);
    } else {
      partnerChkArr = partnerChkArr.filter((v) => v !== nowId);
      iconRecy.innerHTML =
        partnerPart1 + "?chkIds=" + partnerChkArr.join() + partnerPart2;
      console.log(iconRecy.innerHTML);
    }
  });
});
