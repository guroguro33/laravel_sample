<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-8">
        <div class="card">
          <div class="card-header">
            {{ title }}
            <span class="badge badge-success">{{ categoryName }}</span>
          </div>
          <div class="card-body text-center drill-body">
            <button class="btn btn-primary" @click="doDrill" v-if="!isStarted">START</button>
            <p v-if="isCountDown" style="font-size: 100px;">{{ countDownNum }}</p>

            <!-- templateタグを使うとタグが何も表示されなくなる -->
            <template v-if="isStarted && !isCountDown && !isEnd">
              <p>{{timerNum}}</p>
              <span
                v-for="(word, index) in problemWords"
                :class="{'text-primary': index < currentWordNum }"
              >{{word}}</span>
            </template>

            <template v-if="isEnd">
              <p>あなたのスコア</p>
              <p>{{typingScore}}</p>
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import keyCodeMap from "../master/keymap";
export default {
  props: ["title", "drill", "categoryName"],
  data: function() {
    return {
      countDownNum: 3, // カウントダウン用
      timerNum: 30, // タイマー
      missNum: 0, // ミス数
      wpm: 0, // WPM
      isStarted: false,
      isEnd: false,
      isCountDown: false,
      currentWordNum: 0, // 現在回答中の文字数目
      currentProblemNum: 0 // 現在の問題番号
    };
  },
  computed: {
    // 問題テキスト（配列型式)
    problemWords: function() {
      // 問題がからっぽの場合
      // if (!Array.from(this.drill["problem" + this.currentProblemNum]).length) {
      //   return null;
      // }
      // Arrayオブジェクトのfromメンバーにより、ドリルが配列に変換
      return Array.from(this.drill["problem" + this.currentProblemNum]);
    },
    // 問題の解答キーコード配列
    problemKeyCodes: function() {
      // 問題がからっぽの場合
      if (!Array.from(this.drill["problem" + this.currentProblemNum]).length) {
        return null;
      }
      console.log(
        "文字列の長さ：" +
          Array.from(this.drill["problem" + this.currentProblemNum]).length
      );

      // テキストから問題のキーコード配列を生成
      let problemKeyCodes = [];
      console.log(
        "問題の配列:" +
          Array.from(this.drill["problem" + this.currentProblemNum])
      );

      // 配列型式にした問題テキストをforEachで配列ごとに処理
      Array.from(this.drill["problem" + this.currentProblemNum]).forEach(
        text => {
          // keyCodeMapの配列にそれぞれ処理する
          // $.each(配列・オブジェクト, function(index, value) {
          //  //繰り返し処理を記述する
          // })
          $.each(keyCodeMap, (keyText, keyCode) => {
            if (text === keyText) {
              problemKeyCodes.push(keyCode);
            }
          });
        }
      );

      console.log("problemKeyCodes:" + problemKeyCodes);

      return problemKeyCodes;
    },
    // 問題の文字数
    totalWordNum: function() {
      return this.problemKeyCodes.length;
    },
    // タイピングスコア
    typingScore: function() {
      // wpmは30sなので２倍している
      return this.wpm * 2 * (1 - this.missNum / (this.wpm * 2));
    }
  },
  methods: {
    doDrill: function() {
      this.isStarted = true;
      this.countDown();
    },
    countDown: function() {
      // 効果音読み込み
      const countSound = new Audio("../sounds/Countdown01-5.mp3");
      const startSound = new Audio("../sounds/Countdown01-6.mp3");

      this.isCountDown = true;

      this.soundPlay(countSound);

      let timer = window.setInterval(() => {
        this.countDownNum -= 1;

        if (this.countDownNum <= 0) {
          this.isCountDown = false;

          // スタート音再生
          this.soundPlay(startSound);

          // timerをクリアーしてcountTimerとshowFirstProblemを実行
          window.clearInterval(timer);
          this.countTimer();
          this.showFirstProblem();

          return;
        }
        // 先頭から再生するために0を代入
        countSound.currentTime = 0;
        // 再生
        countSound.play();
      }, 1000);
    },
    showFirstProblem: function() {
      // 効果音読み込み
      const okSound = new Audio("../sounds/punch-middle2.mp3");
      const ngSound = new Audio("../sounds/sword-clash4.mp3");
      const nextSound = new Audio("../sounds/punch-high2.mp3");

      // 入力イベント時に入力キーと解答キーをチェック
      $(window).on("keypress", e => {
        // e.whichで押されたキーコードを取得
        console.log(e.which);
        if (e.which === this.problemKeyCodes[this.currentWordNum]) {
          console.log("正解！！");

          this.soundPlay(okSound);

          ++this.currentWordNum;
          ++this.wpm;
          console.log("現在解答の文字数目：" + this.currentWordNum);

          // 全文字の正解が終わったら、次の問題へ
          if (this.totalWordNum === this.currentWordNum) {
            console.log("次の問題へ！");
            ++this.currentProblemNum;
            this.currentWordNum = 0;

            this.soundPlay(nextSound);

            // if (this.currentProblemNum == 10) {
            //   console.log("おしまい");
            //   this.isEnd = true;
            // }
          }
        } else {
          console.log("不正解です");

          this.soundPlay(ngSound);
          ++this.missNum;

          console.log("現在解答の文字数目：" + this.currentWordNum);
        }
      });
    },
    soundPlay: function(sound) {
      // 最初から再生
      sound.currentTime = 0;
      sound.play();
    },
    countTimer: function() {
      const endSound = new Audio("../sounds/gong-played2.mp3");

      let timer = window.setInterval(() => {
        this.timerNum -= 1;

        if (this.timerNum <= 0 || this.currentProblemNum == 10) {
          this.isEnd = true;
          console.log("おしまい");

          window.clearInterval(timer);
          endSound.play();
        }
      }, 1000);
    }
  }
};
</script>

