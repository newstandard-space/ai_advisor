<template>
  <div class="section-box">
    <div v-if="Object.keys(chats).length">
      <div v-for="chat in chats" :key="chat.id">
        <div v-if="chat.question">
          <p v-html="chat.question"></p>
        </div>
        <div v-if="chat.answer">
          <p v-html="chat.answer.slice(14)"></p>
        </div>
        <br />
      </div>
    </div>
  </div>
  <div class="form-box">
    <div class="textarea-box">
      <form method="GET" action="#">
        <textarea
          name="textarea"
          id="text"
          cols="30"
          rows="10"
          v-model="text"
        ></textarea>
        <!-- <div class="form-spinner-box" :class="{ hidden: !isGenerating }">
          <div class="spinner-border text-secondary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div> -->
        <button
          type="submit"
          @click="generate"
          :disabled="isGenerating"
          :class="{ hidden: false }"
        >
          <i class="bi bi-send" style="font-size: 30px"></i>
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import { ref } from "vue";
export default {
  setup() {
    const chats = ref({});
    const isGenerating = ref(false);
    const text = ref("");
    let saveChats = {};
    let saveChat = {};

    function getAll() {
      axios
        .get("/getAll")
        .then((res) => {
          chats.value = res.data.chats;
          saveChats = res.data.chats;
        })
        .catch((err) => {
          console.log("getAll/失敗", err);
        });
    }

    getAll();

    const generate = (e) => {
      e.preventDefault();
      if (text.value == "") return false;

      let tmpText = text.value;
      text.value = "";
      isGenerating.value = true;

      let time = new Date();
      let id =
        time.getFullYear().toString().padStart(2, "0") +
        (time.getMonth() + 1).toString().padStart(2, "0") +
        time.getDate().toString().padStart(2, "0") +
        time.getHours().toString().padStart(2, "0") +
        time.getMinutes().toString().padStart(2, "0") +
        time.getSeconds().toString().padStart(2, "0") +
        time.getMilliseconds().toString();

      saveChat = { id: id, question: tmpText };
      saveChats.push(saveChat);

      chats.value = saveChats;

      axios
        .put("/generate", {
          text: tmpText,
        })
        .then((res) => {
          let answer = res.data.chat.answer;

          let last = Object.keys(saveChats).pop();
          saveChats[last]["answer"] = answer;
          chats.value = saveChats;
          isGenerating.value = false;
        })
        .catch((err) => {
          console.log("generate/失敗", err);
          isGenerating.value = false;
        });

    };

    return { generate, chats, isGenerating, text };
  },
};
</script>