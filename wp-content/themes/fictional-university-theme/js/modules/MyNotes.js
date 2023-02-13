import $ from 'jquery'
class MyNotes {
  constructor () {
    this.events()
  }
  events () {
    $('#my-notes').on('click', '.delete-note', this.deleteNote)
    $('#my-notes').on('click', '.edit-note', this.editNote.bind(this))
    $('#my-notes').on('click', '.update-note', this.updateNote.bind(this))
    $('.submit-note').on('click', this.createNote.bind(this))
  }
  deleteNote (e) {
    var thisNote = $(e.target).parents('li')
    $.ajax({
      beforeSend: xhr => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
      },
      url:
        universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
      type: 'DELETE',
      success: response => {
        thisNote.slideUp()
        if (response.user_note_count < 5) {
          $('.note-limit-message').removeClass('active')
        }
      },
      error: response => {
        console.log('Something went wrong')
        console.log(response)
      }
    })
  }
  updateNote (e) {
    var thisNote = $(e.target).parents('li')
    var updatedNote = {
      title: thisNote.find('.note-title-field').val(),
      content: thisNote.find('.note-body-field').val()
    }
    $.ajax({
      beforeSend: xhr => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
      },
      url:
        universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
      type: 'POST',
      data: updatedNote,
      success: response => {
        this.makeNoteReadOnly(thisNote)
        console.log(response)
      },
      error: response => {
        console.log('Something went wrong')
        console.log(response)
      }
    })
  }
  createNote (e) {
    var thisNote = $(e.target).parents('li')
    var createdNote = {
      title: $('.new-note-title').val(),
      content: $('.new-note-body').val(),
      status: 'publish'
    }
    $.ajax({
      beforeSend: xhr => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
      },
      url: universityData.root_url + '/wp-json/wp/v2/note/',
      type: 'POST',
      data: createdNote,
      success: response => {
        $('.new-note-title', '.new-note-body').val('')
        $(`
        <li data-status="readonly" data-id="${response.id}">
                    <input readonly class="note-title-field" type="text" value="${response.title.raw}">
                    <span class="edit-note" aria-hidden="true">
                        <i class="fa fa-pencil"></i>
                        Edit
                    </span>
                    <span class="delete-note" aria-hidden="true">
                        <i class="fa fa-trash-o"></i>
                        Delete
                    </span>
                    <textarea readonly class="note-body-field">${response.content.raw}</textarea>
                    <span class="update-note btn btn--blue btn--small" aria-hidden="true">
                        <i class="fa fa-arrow-right"></i>
                        Save
                    </span>
                </li>
        `)
          .prependTo('#my-notes')
          .hide()
          .slideDown()
        console.log(response)
      },
      error: response => {
        if (response.responseText == 'You have reach your posts limit.') {
          $('.note-limit-message').addClass('active')
        }
        console.log('Something went wrong')
        console.log(response)
      }
    })
  }
  editNote (e) {
    var thisNote = $(e.target).parents('li')
    if (thisNote.data('status') == 'readonly') {
      this.makeNoteEditable(thisNote)
    } else {
      this.makeNoteReadOnly(thisNote)
    }
  }
  makeNoteEditable (thisNote) {
    thisNote.data('status', 'editable')
    thisNote
      .find('.edit-note')
      .html('<i class="fa fa-times" aria-hidden="true"></i>Cancel')
    thisNote
      .find('.note-title-field,.note-body-field')
      .removeAttr('readonly')
      .addClass('note-active-field')
    thisNote.find('.update-note').addClass('update-note--visible')
  }
  makeNoteReadOnly (thisNote) {
    thisNote.data('status', 'readonly')
    thisNote
      .find('.edit-note')
      .html('<i class="fa fa-pencil" aria-hidden="true"></i>Edit')
    thisNote
      .find('.note-title-field,.note-body-field')
      .attr('readonly', 'readonly')
      .removeClass('note-active-field')
    thisNote.find('.update-note').removeClass('update-note--visible')
  }
}

export default MyNotes
