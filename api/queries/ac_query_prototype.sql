SELECT tb_journal.journal_id, tb_journal.schedule_id, student_name, grade_name, lesson_name, description, presence_status, tb_journal.created FROM `tb_journal`
JOIN tb_presence ON tb_journal.journal_id=tb_presence.journal_id
JOIN tb_student ON tb_presence.student_id=tb_student.student_id
JOIN tb_schedule ON tb_journal.schedule_id=tb_schedule.schedule_id
JOIN tb_lessons_grade ON tb_schedule.lessons_grade_id=tb_lessons_grade.lessons_grade_id
JOIN tb_grade ON tb_lessons_grade.grade_id=tb_grade.grade_id
JOIN tb_lessons ON tb_lessons_grade.lesson_id=tb_lessons.lesson_id
WHERE tb_journal.created BETWEEN '2022-02-01 00:00:00' AND '2022-02-28 00:00:00' AND tb_grade.grade_id=6 ORDER BY tb_journal.created, schedule_order  ASC;