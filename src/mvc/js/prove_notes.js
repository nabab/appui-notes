(function(){
  return {
    mounted: function(){
      /*
      var vm = this;
      //bbn.fn.log('array prove_notes', this.prove_notes);
      //Populating of fancy_obj empty array that will be the data of fancytree. this.$data refers to Vue's data. Map() browses the properties of every object (v) in the given array.
      this.$data.fancy_obj = $.map(this.prove_notes, function(v){
        //var r contains the new property to assign to the object
        var r = {
          title: v.myid/*v.title ? v.title : 'no-title',,
          icon: v.num_children ? 'nf nf-fa-folder' : 'nf nf-fa-sticky_note' ,
          data: {},
          folder: v.num_children ? true : false,
          id: v.myid,

        };
        //the old property n of the object v will be in r.data; r.data[n] will be the value of property n
        for ( var n in v ) {
          r.data[n] = v[n];
        }
        //lazy attribute of fancyTree triggers the method src
        if ( v.num_children  ){
          r.lazy = true;
        }
        else{
          r.lazy = false;
        }
        return r;
      });
      vm.load_tree();
      bbn.fn.analyzeContent($ele);
      //bbn.fn.log('fancy_obj',this.$data.fancy_obj[0]);
      */
    },
    //window.notes.fancy_obj[0] is a fancyTree obj with properties: data, folder icon, id, lazy, title
    //window.notes.fancy_obj[2].data contains the properties from the model: creator, id, id_parent, locked, medias, num_children, pinned, private, title.
    methods: {
      //method src is triggered when lazy = true, it makes a post to 'lazy_load' controller sending the parent's id, in the controller the old data is merged with the new one arriving from the model.
      src: function(id){
        return this.post(data.root + 'lazy_load', {id: id}).promise().then(function(d){
          //(d) is the data received from the post and in d.data.prove_notes contains the array of the children of the selected node.
          //bbn.fn.log('data_from_the_post', d);
          if ( d.data && d.data.prove_notes ){
            //mapping of childrens' properties
            //return $.map(d.data.prove_notes, function(v){
            return bbn.fn.map(d.data.prove_notes, v =>{
              //(v) at this point v is the children of the focused node
              // bbn.fn.log('v_children',v);
              //var r contains the new property to assign to the object
              var r = {
                title: v.myid/*v.title ? v.title : 'no-title',*/,
                icon: v.num_children ? 'nf nf-fa-folder' : 'nf nf-fa-sticky_note' ,
                data: {},
                folder: v.num_children ? true : false,
                id: v.myid,
                //icon: v.icon && (v.icon.indexOf(" ") > -1) ? v.icon : 'nf nf-fa-cog',
              };
              //setting of lazy attribute
              if ( v.num_children ){
                r.lazy = true;
              }
              //the value v's property are assigned to r.data[n]
              for ( var n in v ){
                r.data[n] = v[n];
              }
              return r;
            });
          }
        });
      },
      //load_tree is the method called in the <div id='fancy'>
      /*load_tree: function(){
        var $$ = this;
        $('#fancy').fancytree({
          extensions: ['dnd'],
          //titlesTabbable: true,
          activateVisible: true,
          source: this.$data.fancy_obj,
          click: function (e, d) {
            bbn.fn.log('data',d);
            //alert("activate id" + d.node.data.id);
          },
          lazyLoad: function(e, d){
            d.result = $$.src(d.node.data.id);
            //bbn.fn.log('d_lazyLoad', d, 'd.result', d.result);
          },
          dnd: {
            // focusOnClick:true,
            // preventForeignNodes: true,
            // preventNonNodes: true,
            preventRecursiveMoves: true, // Prevent dropping nodes on own descendants
            // preventVoidMoves: true, // Prevent dropping nodes 'before self', etc.

            dragStart: function(node, data) {
              bbn.fn.log('dragstart', node.data.id, data.node.data.id);
              return true;
            },
            dragEnter: function(node, data) {
              bbn.fn.log('dragenter', data.hitMode);

              if ( (data.hitMode === 'after') || (data.hitMode === 'before') ){
                return !node.data.id_parent && data.otherNode.data.id_parent ? true : false;
              }
              if ( node === data.otherNode.parent ){
                return false;
              }
              if ( node.data.id === 0 ){
                return false;
              }

              return true;
              //return node.isFolder();
            },
            dragDrop: function(node, dat) {
              bbn.fn.log('dragdrop', dat.hitMode, node.data.id, dat.node.data.id, 'dat.otherNode',dat.otherNode, 'dat', dat);
              // bbn.fn.log("node/dataDragDrop",node,data);
              if ( node.data.id != -1 ){
                this.post(data.root + 'move', {
                  id_parent: node.data.id,
                  id:dat.otherNode.data.id
                }, function(d){
                  bbn.fn.log('d',d, 'd.success', d);
                  if ( d && d.success ){
                    if(dat.otherNode.folder){
                      var c = confirm('Do you want to move folder' + dat.otherNode.data.id + ' into' +
                                      ' folder' +
                                      ' ' + dat.node.data.id + '?')
                      }
                    else{
                      var f =confirm('Do you want to move note' + dat.otherNode.data.id + ' into folder' +
                                     ' ' + dat.node.data.id + '?')
                      }
                  }

                  if(d||f){
                    data.otherNode.moveTo(node);
                    $('#tree').fancytree();
                  }



                  else{
                    alert("Something went wrong");
                  }
                });
              }
              else{
                alert("Something went wrong");
              }
            }

          }

        });
      }*/
        },
  }
})();