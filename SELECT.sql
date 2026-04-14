SELECT
    p.fileNo,
    p.surname,
    p.first_name,
    p.othernames,
    p.grade,
    p.step,
    e.employmentType,   -- get the actual employment type name
    p.status_value
FROM tblper p
LEFT JOIN tblemployment_type e
    ON p.employee_type = e.id
WHERE p.staff_status = 1
  AND p.rank != 2
LIMIT 2000;
