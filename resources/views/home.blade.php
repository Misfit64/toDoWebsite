@props(['tasks' => []])

<x-app-layout>
    @push('scripts')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
    @endpush
    <h2 class="text-center mt-5">toDo's
        <button type="button" class="btn btn-outline-secondary border-0" id="createTaskBtn">
            <i class="fas fa-circle-plus" style="font-size:1.2rem"></i>
        </button>
    </h2>
    <div class="container dflex align-items-center flex-column mt-5">
        <table class="table table-striped">
        @forelse ($tasks as $task)
                <tr data-id="{{ $task->id }}">
                    <x-task :$task />
                    <x-buttons />
                </tr>
                @empty
                <x-task-row />
                @endforelse
            </table>
    </div>

<div aria-live="polite" aria-atomic="true" class="position-relative">
  <div id='toastContainer' class="toast-container position-fixed top-0 end-0 p-5">
    {{-- toast --}}

  </div>
</div>




<script>
    function createToast(message,timestamp='just_now') {
        $('#toastContainer').prepend(`<x-toast />`).find('[data-bs-body]').first().text(`${message}`)

        let newToastElement = $('#newToast')
        let newToast = new bootstrap.Toast(newToastElement,{delay:2000})

        newToastElement.on('hidden.bs.toast', () => newToastElement.remove());

        newToast.show();
    }
    @if(Session::has('success'))
        createToast("{{ Session::get('success') }}");
    @endif

</script>

    <script>
        table = document.querySelector("tbody");
        table.addEventListener("click",tbodyEventHandler);

        function fristTaskRow(){
            if(table.children.length ==0){
                        table.insertAdjacentHTML('beforeend',`<x-task-row />`)
            }

            firstTaskBtn = document.querySelector("#firstTaskBtn");
            if(firstTaskBtn){
                firstTaskBtn.addEventListener("click",createRowHandler);
            }
        }

        fristTaskRow();

        createBtn = document.querySelector("#createTaskBtn");
        createBtn.addEventListener("click", createRowHandler);

        function createRowHandler(e) {
            if(e.target.closest('#firstTaskBtn')){
                e.target.closest('tr').remove();
            }else{
                row = document.querySelector('#forEmptyRow');
                if(row){
                    row.remove();
                }
            }
            createBtn.removeEventListener("click", createRowHandler);
            new_task = document.createElement('tr');
            new_task.innerHTML = `<x-task :create='true'/>
                                <x-buttons />`;
            table.prepend(new_task);
            input_task = new_task.querySelector('input[type=text]');
            input_task.focus();
            input_task.addEventListener('keydown',(e)=>{
                if(e.key === 'Enter'){
                    e.target.blur();
                }
            })
            input_task.addEventListener('blur',createTaskHandler);

        }

        function createTaskHandler(e){
            if(!e.target.value){
                if(e.target.closest('tr')){
                    e.target.closest('tr').remove();
                    fristTaskRow();
                    createBtn.addEventListener("click", createRowHandler);
                }
                return
            }
            newTask = e.target.value
            axios.post('/task/create',{
                task: newTask
            })
            .then((response)=>{
                e.target.disabled = true;
                new_task.setAttribute('data-id',response.data);
                createBtn.addEventListener("click", createRowHandler);
                createToast("Task successfully created");
            })
            .catch((error)=>{
                console.error(error)
            });
        }

        function tbodyEventHandler(e){
            if(e.target.matches('input[type="checkbox"]')){
                checkboxEventHandler(e);
            }
            else if(e.target.closest('button[type="button"]')){
                if(e.target.closest('button[type="button"]').textContent.trim() == "Edit"){
                    editRowHandler(e);
                }
                else if(e.target.closest('button[type="button"]').textContent.trim() == "Delete"){
                    deleteEventHandler(e);
                }
            }
        }

        function checkboxEventHandler(e){
            row = e.target.closest('tr');
            task_id = row.dataset.id;
            if(!task_id){
                return
            }
            row.querySelector("input[type=text]").classList.toggle('text-decoration-line-through')
            axios.patch(`task/${task_id}/status`)
            .then(response=>{
                createToast("Task updated")
            })
            .catch(error =>{
                console.error(error);
            })
        }

        function editRowHandler(e){
            row = e.target.closest('tr');
            task_id = row.getAttribute('data-id')
            if(!task_id){
                return
            }
            input = row.querySelector('input[type=text]');
            if(!input.value){
                return
            }
            old_input = input.value;
            input.disabled = false;
            input.focus();
            length = input.value.length;
            input.setSelectionRange(length,length)
            input.addEventListener('keydown',(e)=>{
                if(e.key === 'Enter'){
                    e.target.blur();
                }
            })
            input.addEventListener('blur',editEventHandler)
        }

        function editEventHandler(e){
            if(old_input == e.target.value){
                input.disabled = true;
                return
            }
            axios.put(`/task/${task_id}/edit`,{
                task: e.target.value
            })
            .then(response=>{
                input.disabled = true;
                input.removeEventListener('blur',editEventHandler)
                createToast("Task successfully updated.");
            })
            .catch(error=>{
                console.error(error);
            })
        }

        function deleteEventHandler(e){
            row = e.target.closest('tr');
            task_id = row.getAttribute('data-id')
            if(!task_id){
                return
            }
            axios.delete(`/task/${task_id}/delete`)
                .then((response) =>{
                    row.remove();
                    fristTaskRow();
                    createToast("Task successfully deleted.");
                })
                .catch((error) =>{
                    console.error(error);
                });

        }
    </script>
</x-app-layout>
