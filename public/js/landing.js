/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************************!*\
  !*** ./resources/js/landing/landing.js ***!
  \*****************************************/
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e2) { throw _e2; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e3) { didErr = true; err = _e3; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

//переход по ссылкам
function SendMessage() {
  var re = /^(\+)?(\(\d{2,3}\) ?\d|\d)(([ \-]?\d)|( ?\(\d{2,3}\) ?)){5,12}\d$/;
  userNumber = document.getElementById('usernumber').value;
  userName = document.getElementById('username');
  userText = document.getElementById('usertext');
  var valid = re.test(userNumber);
  if (valid) output = 'Номер телефона введен правильно!';else output = 'Номер телефона введен неправильно!';
  alert(output);
}

function redirectTo(href) {
  switch (href) {
    case 'logo':
      window.location.href = "#logo";
      break;

    case 'freeaccess':
      window.location.href = "#freeaccess";
      break;

    case 'wanttouse':
      window.location.href = "#wanttouse";
      break;

    case 'sendmessage':
      SendMessage();
      window.location.href = "#sendmessage";
      break;

    case 'writetobot':
      window.location.href = "#writetobot";
      break;

    case 'social':
      window.location.href = "#telegram";
      break;

    case 'vk':
      window.location.href = "#vk";
      break;

    case 'facebook':
      window.location.href = "#facebook";
      break;

    case 'talkme':
      window.location.href = "#talkme";
      break;

    case 'onlinechat':
      window.location.href = "#onlinechat";
      break;

    case 'whatsapp':
      window.location.href = "#whatsapp";
      break;

    case 'viber':
      window.location.href = "#viber";
      break;

    case 'webim':
      window.location.href = "#webim";
      break;

    case 'whatsappbusiness':
      window.location.href = "#whatsappbusiness";
      break;

    case 'livetex':
      window.location.href = "#livetex";
      break;

    case 'avito':
      window.location.href = "#avito";
      break;

    case 'odnoclassniki':
      window.location.href = "#odnoclassniki";
      break;

    case 'instagram':
      window.location.href = "#instagram";
      break;

    case 'add':
      window.location.href = "#add";
      break;
  }
}

document.getElementById("trigger").onclick = function () {
  open();
};

function open() {
  document.getElementById("menu").classList.toggle("show");
  document.getElementById("trigger").classList.toggle("show");
} //Тарифы


var services = ["Online-chat", "Бот для мессенджеров", "Бот для Whatsapp", "Сбор заявок", "Графический редактор", "Отправка медиафайлов", "CRM", "Перенос клиентской базы", "Инструменты оператора", "Статистика", "Рассылки", "Bitrix, AmoCRM", "Работа с API", "Запись/бронирование", "Работа с Google таблицами", "Программируемая логика", "Высокая нагрузка", "Оплаты в боте"];
var base = "base",
    standart = "standart",
    premium = "premium";
var tarifs = new Map();
tarifs.set(base, 10);
tarifs.set(standart, 12);
tarifs.set(premium, 18);
$(document).ready(function () {
  FillServices();
  SetTarifs();
});

function FillServices() {
  var el = document.getElementById("services");
  services.forEach(function (v) {
    var li = document.createElement('li');
    li.textContent = v;
    el.appendChild(li);
  });
}

function SetTarifs() {
  var elindex = 0;

  var _iterator = _createForOfIteratorHelper(tarifs),
      _step;

  try {
    for (_iterator.s(); !(_step = _iterator.n()).done;) {
      var _step$value = _slicedToArray(_step.value, 2),
          key = _step$value[0],
          value = _step$value[1];

      var el = document.getElementById(key);
      services.forEach(function (v) {
        var li = document.createElement('li');
        var div = document.createElement('div');
        var p = document.createElement('p');
        p.textContent = v;

        if (elindex < value) {
          li.classList.toggle("have");
        } else {
          li.classList.toggle("donthave");
        }

        li.appendChild(p);
        li.appendChild(div);
        el.appendChild(li);
        elindex++;
      });
      elindex = 0;
    }
  } catch (err) {
    _iterator.e(err);
  } finally {
    _iterator.f();
  }
} //Каруселька


callOwlCarousel();

function callOwlCarousel() {
  $('.owl-carousel').owlCarousel({
    touchDrag: true,
    dots: true,
    loop: true,
    items: 1
  });
} //Чатик


document.getElementById("chattriger").onclick = function () {
  openChat();
};

document.getElementById("chatclose").onclick = function () {
  openChat();
};

function openChat() {
  document.getElementById("chatcontainer").classList.toggle("show");
  document.getElementById("chattriger").classList.toggle("notshow");
  /* document.getElementById('chatcontainer').addEventListener('keypress', function (e) {
   if (e.key === 'Enter') {
     sendMassegeBot(document.getElementById('usermassege1'),1);
   }
  });*/

  PressEnter('chatcontainer', 'usermassege1', 1);
}

function PressEnter(cntainerId, inputId, chatNumber) {
  document.getElementById(cntainerId).addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
      sendMassegeBot(document.getElementById(inputId), chatNumber);
    }
  });
}

function answerMassegeBot(answer, id) {
  content = document.getElementsByClassName("contentChat")[id];
  var text = document.createElement('div');
  text.classList.toggle("text");
  text.textContent = answer;
  var botMassege = document.createElement('div');
  botMassege.classList.toggle("botmessage");
  botMassege.appendChild(text);
  content.appendChild(botMassege);
}

function sendAnswer(text, id) {
  if (text == 'Привет!') {
    answerMassegeBot("Мяу...", id);
  } else if (text == "Пока!") {
    answerMassegeBot("Мяу, мяу, мяу...", id);
  } else {
    answerMassegeBot("Я вас не понимаю!", id);
  }
}

function sendMassegeBot(usermassege, id) {
  if (usermassege.value != '') {
    content = document.getElementsByClassName("contentChat")[id];
    var text = document.createElement('div');
    text.classList.toggle("text");
    text.textContent = usermassege.value;
    var userMassege = document.createElement('div');
    userMassege.classList.toggle("usermessage");
    userMassege.appendChild(text);
    content.appendChild(userMassege);
    sendAnswer(usermassege.value, id);
    usermassege.value = "";
  }
}
/******/ })()
;