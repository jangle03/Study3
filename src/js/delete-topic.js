function deleteTopic(id) {
        Swal.fire({
            title: 'Are you sure you want to delete this topic?',
            text: "All vocabulary in this topic is also deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete!',
            cancelButtonText: 'Cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('', {
                    delete_topic_id: id
                }, function(response) {
                    const res = JSON.parse(response);
                    if (res.success) {
                        $('#topic-' + id).remove();
                        Swal.fire('Deleted!', 'The topic has been successfully deleted.', 'success');
                    } else {
                        Swal.fire('Error!', 'Unable to delete the topic.', 'error');
                    }
                });
            }
        });
    }