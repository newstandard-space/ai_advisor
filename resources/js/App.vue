<template>
  <div class="section-box">
    <div v-for="chat in chats" :key="chat.id">
      <div>
        <p v-html="chat.question"></p>
      </div>
      <div>
        <p v-html="chat.answer.slice(14)"></p>
      </div>
      <br>
    </div>
  </div>
  <div class="form-box">
    <div class="textarea-box">
      <form method="GET" action="#">
        <textarea name="textarea" id="text" cols="30" rows="10"></textarea>
        <button type="submit" @click="generate">
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
    let chats = ref([]);

    function getAll() {
      axios
        .get("/getAll")
        .then((res) => {
          console.log(res);
          chats.value = res.data.chats;
        })
        .catch((err) => {
          console.log(err);
        });
    }

    getAll();

    const generate = (e) => {
      e.preventDefault();
      let text = document.getElementById("text").value;
      console.log(text);
      axios
        .put("/generate", {
          text: text,
        })
        .then((res) => {
          console.log(res.data.text);
        })
        .catch((err) => {
          console.log(err);
        });
    };

    return { generate, chats };
  },
};
</script>