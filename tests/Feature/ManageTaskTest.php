<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Task;

class ManageTaskTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function user_can_create_a_taskTest()
    {
        // User buka halaman Daftar Task
        $this->visit('/tasks');

        // klik tombol create tasks
        //$this->click('Create Task')->seePageIs('/tasks/create');

        // Isi form `name` dan `description` kemudian submit

        $this->type('My First Task', 'name');
        $this->type('This is my first task with tdd', 'description');
        $this->press('Create Task');

        // Lihat Record tersimpan ke database
        $this->seeInDatabase('tasks', [
            'name' => 'My First Task',
            'description' => 'This is my first task with tdd',
            'is_done' => 0
        ]);

        // Redirect ke halaman Daftar Task
        $this->seePageIs('/tasks');
        
        // Tampil hasil task yang telah diinput
        $this->see('My First Task');
        $this->see('This is my first task with tdd');
    }

    /** @test */
    public function task_entry_must_pass_validation()
    {
        $this->post('/tasks', [
            'name' => '',
            'description' => ''
        ]);

        $this->assertSessionHasErrors(['name', 'description']);
    }

    /** @test */
    public function user_can_browser_task_index_pageTest()
    {
        // Generate 3 record task pada table `tasks`.
        $tasks = factory(Task::class, 3)->create();
        
        // User membuka halaman Daftar Task.
        $this->visit('/tasks');

        for ($i=0; $i < count($tasks); $i++) { 
            // User melihat ketiga task tampil pada halaman.
            $this->see($tasks[$i]->name);
            // User melihat link untuk edit task pada masing-masing item task.
            $this->seeElement('a', [
                'href' => route('tasks.edit',$tasks[$i]->id)
            ]);
        }

    }

    /** @test */
    public function user_can_edit_an_existing_taskTest()
    {
        // buat 1 record tasks pada tabel tasks
        $task  =  factory(Task::class)->create();

        //dd($task);

        // user membuka daftar tasks
        $this->visit('/tasks');

        // klik tombol edit task lalu lihat url yang dituju sesuai dengan target
        $this->click('Ubah')->seePageIs('/tasks/' . $task->id . '/edit');

        // tampilkan form edit task
        $this->seeElement('form', [
            'action' => route('tasks.update', $task->id)
        ]);

        // user submit form berisi nama dan deskripsi task yang baru

        $this->type('Updated Task', 'name')
             ->type('Updated task description', 'description')
             ->press('Simpan')->seePageIs('/tasks');

        // lihat record pada database
        $this->seeInDatabase('tasks', [
            'id' => $task->id,
            'name' => 'Updated Task',
            'description' => 'Updated task description'
        ]);
    }

    /** @test */
    public function user_can_delete_an_existing_taskTest()
    {
        // buat 1 record pada task 
        $task = factory(Task::class)->create();

        // user buka halaman task index
        $this->visit('/tasks');
        
        // user tekan tombol hapus task, halaman redirect ke task index
        $this->press('Hapus')->seePageIs('/tasks');

        // record task hilang dari database
        $this->dontSeeInDatabase('tasks', [
          'id' => $task->id
        ]);
    }
}
