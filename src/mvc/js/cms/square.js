// Javascript Document

(() => {
  return {
    data(){
      let lines = [];
      if (this.source.lines.length) {
        bbn.fn.each(this.source.lines, a => {
          lines.push(a);
        })
      }

      lines.push({
        content: '[CONTENT]',
        type: 'html'
      });

      return {
        focused: lines.length - 1,
        lines: lines,
        blockChoice: [
          {
            text: 'HTML Content',
            icon: 'nf nf-seti-text',
            code: 'html',
            action(){
              alert('world')
            }
          }, {
            text: 'Image gallery',
            icon: 'nf nf-mdi-image_multiple',
            code: 'gallery',
            action(){
              alert('world')
            }
          }
        ]
      };
    },
    methods: {
      render(){
        return '[CONTENT]'
      },
      add(line){
        this.getPopup({
          title: bbn._("Pick a block type to insert"),
          content: 'Woo'
        });
      }
    },
    components: {
      control: {
        computed: {
          blockChoice() {
            return this.$parent.blockChoice;
          }
        },
        methods: {
          add(){
            return this.$parent.add(this.source);
          }
        }
      }
    }
  };
})();