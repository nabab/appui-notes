/**
 * Created by BBN Solutions.
 * User: Mirko Argentino
 * Date: 12/04/2018
 * Time: 18:36
 */
(() => {
  return {
    props: {
      source: {
        type: Object
      }
    },
    data(){
      return {
				formAction: this.source.props.formAction || false,
        fileSave: this.source.props.fileSave || false,
        fileRemove: this.source.props.fileRemove || false,
        imageDom: this.source.props.imageDom || false,
				linkPreview: this.source.props.linkPreview || false,
        editorTypes: [{
          text: bbn._('Simple text'),
          value: 'bbn-textarea'
        }, {
          text: bbn._('Rich text'),
          value: 'bbn-rte'
        }, {
          text: bbn._('Markdown'),
          value: 'bbn-markdown'
        }, {
          text: bbn._('PHP code'),
          value: 'bbn-code',
          mode: 'php'
        }, {
          text: bbn._('JavaScript code'),
          value: 'bbn-code',
          mode: 'javascript'
        }, {
          text: bbn._('CSS code'),
          value: 'bbn-code',
          mode: 'less'
        }],
        editorType: 'bbn-textarea',
        data: {
					ref: moment().unix()
				}
      }
    },
    methods: {
      switchEditorType(){
        let mode;
        if ( this.$refs.editorType.widget ){
          this.editorType = this.$refs.editorType.widget.value();
          if ( (this.editorType === 'bbn-code') && (mode = this.$refs.editorType.widget.dataItem()['mode']) ){
            setTimeout(() => {
              this.$refs.editor.widget.setOption('mode', mode);
            }, 500);
          }
        }
      },
			linkEnter(){
        const link = (this.$refs.link.$refs.element.value.indexOf('http') !== 0 ? 'http://' : '') +
                this.$refs.link.$refs.element.value,
              idx = this.source.row.links.push({
                inProgress: true,
                url: link,
                image: false,
                desc: false,
                title: false,
                error: false
              }) - 1;
				if ( this.linkPreview ){
					bbn.fn.post(this.linkPreview, {
	          url: link,
	          ref: this.data.ref
	        }, (d) => {
	          if ( d.data && d.data.realurl ){
	            if ( d.data.picture ){
	              this.source.row.links[idx].image = d.data.picture;
	            }
	            if ( d.data.title ){
	              this.source.row.links[idx].title = d.data.title;
	            }
	            if ( d.data.desc ){
	              this.source.row.links[idx].desc = d.data.desc;
	            }
	            this.source.row.links[idx].inProgress = false;
	            this.$refs.link.$refs.element.value = '';
	          }
	          else{
	            this.source.row.links[idx].error = true;
	          }
	        });
				}
      },
      linkRemove(idx){
        if ( idx !== undefined){
          bbn.fn.confirm(bbn._('Are you sure you want to remove this link?'), () => {
            this.source.row.links.splice(idx, 1);
          });
        }
      }
    }
  }
})();
