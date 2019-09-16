<!-- HTML Document -->
<html>
<head>
<script src="https://cdn.thomas.lan/?lib=bbn-vue"></script>
</head>
<body>
  <div class="bbn-container">
    <bbn-rte @input="log" v-model="text"></bbn-rte>
  </div>
  <script>
    new Vue({
      el: 'div.bbn-container',
      data: {
        text: '',
        uid: null
      },
      methods: {
        log(){
          window.parent.postMessage({
            text: this.text,
            uid: this.uid
          }, '*');
        }
      },
      created(){
        window.addEventListener('message', msg => {
          console.log("Got a message");
          console.log(msg);
          this.uid = msg.data;
        })
      }
    });
  </script>
</body>
</html>