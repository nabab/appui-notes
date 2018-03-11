/**
 * Created by BBN Solutions.
 * User: Mirko Argentino
 * Date: 06/03/2018
 * Time: 16:36
 */

(() => {
  return {
    props: ['source'],
    computed: {
      userName(){
        return appui.userName(this.source.id_user);
      },
      creationDate(){
        return moment(this.source.creation).format('DD/MM/YYYY');
      },
      creationTime(){
        return moment(this.source.creation).format('HH:mm');
      }
    }
  }
})();