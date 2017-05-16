/**
 * Created by BBN on 06/11/2016.
 */

var
    $ele = $(ele),
    postIt = new Vue({
      el: '#bbn-postit-container',
      //se 'el:ele' vue da un errore
      data: {
        notes: data.notes
      },
      methods: {
        myTitle: function(note){
          return note.title.length ? note.title : '';
        },
        editContent: function(e){
          var $c = $(e.target).closest(".bbn-postit").find("div.content");
          bbn.fn.log($c.length);
          $c.attr("contenteditable", true).focus();
        }
      },
      mounted: function(){
        $(".bbn-postit", ele).each(function(){
          var r = Math.random(),
              r2 = Math.random(),
              n = r > 0.5 ? r * 7 : r * -7,
              cols = [
                '#009FD6',
                '#009FD6',
                '#FDB44D',
                '#FDB44D',
                '#FE59B5',
                '#FE59B5',
                '#FFFFA5',
                '#FFFFA5',
                '#FFFFA5',
                '#FFFFA5',
              ],
              idx = Math.round(r2*10);

          $(this).css({
            'background-color': cols[idx],
            '-moz-transform': 'rotate(' + n + ')',
            '-webkit-transform': 'rotate(' + n + ')',
            '-o-transform': 'rotate(' + n + ')',
            '-ms-transform': 'rotate(' + n + 'deg)',
            'transform': 'rotate(' + n + 'deg)',
          })
        });
        bbn.fn.analyzeContent($ele);
        bbn.fn.addToggler($ele);
      }
    });
