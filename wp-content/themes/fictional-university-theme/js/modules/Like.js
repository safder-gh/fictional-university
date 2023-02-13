import $ from 'jquery'
class Like {
  constructor () {
    this.likeBox = $('.like-box')
    this.events()
  }
  events () {
    this.likeBox.on('click', this.ourClickDispatcher.bind(this))
  }
  ourClickDispatcher (e) {
    var currentLikeBox = $(e.target).closest('.like-box')
    if (currentLikeBox.attr('data-exists') == 'yes') {
      this.deleteLike(currentLikeBox)
    } else {
      this.createLike(currentLikeBox)
    }
  }
  createLike (likeBox) {
    $.ajax({
      beforeSend: xhr => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
      },
      url: universityData.root_url + '/wp-json/university/v1/manageLike',
      type: 'POST',
      data: { professorId: likeBox.data('professor') },
      success: response => {
        likeBox.attr('data-exists', 'yes')
        likeBox.attr('data-like', response)
        var likeCount = parseInt(likeBox.find('.like-count').html())
        likeCount++
        likeBox.find('.like-count').html(likeCount)
        console.log(response)
      },
      error: response => {
        console.log(response)
      }
    })
  }
  deleteLike (likeBox) {
    $.ajax({
      beforeSend: xhr => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
      },
      url: universityData.root_url + '/wp-json/university/v1/manageLike',
      type: 'DELETE',
      data: { like: likeBox.data('like') },
      success: response => {
        likeBox.attr('data-exists', 'no')
        likeBox.attr('data-like', '')
        var likeCount = parseInt(likeBox.find('.like-count').html())
        likeCount--
        likeBox.find('.like-count').html(likeCount)
        console.log(response)
      },
      error: response => {
        console.log(response)
      }
    })
  }
}
export default Like
