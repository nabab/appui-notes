/**
 * Created by BBN on 06/11/2016.
 */

var postIt = new Vue({
  el: ele,
  data: {
    options: data.options,
    notes: data.notes
  },
  methods: {
    shortTitle: function(title){
      return appui.fn.shorten(title, 25);
    }
  }
});