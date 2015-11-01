# Personio
1) Description
Your goal is to write an algorithm in PHP that calculates the number of remaining vacation days for an employee
2) Vacation day calculation
The logic to calculate vacation days should look as follows: each employee has a hire date (first working day).
During the probation period of 6 months, the employee will receive 2 vacation days per month. After 6 months, the accumulated vacation days will be increased to reach the full yearly vacation of 24 days for the current year.
Example 1: Joe starts on 1st of March 2015. He will receive 2+2+2+2+2+2=12 vacation days on 01.03, 01.04, 01.05, 01.06, 01.07, 01.08 respectively. On the 1st of Sep, he should receive his full 24 days of vacation for the year, so the remaining 12 days will be awarded.
Example 2: Mary starts on the 18th of October 2015. She will receive 2+2+2+2+2+2 vacation days on 18.10, 18.11, 18.12, 18.01, 18.02, 18.03. On the 18th of April, after 6 months, she will be awarded the full 24 days for 2016, so the first three accumulations (18.01, 18.02, 18.03) will be increased by 18 days to reach 24.
However, vacation days always have to be used until the 31st of March of the following year. So, if any vacation days were granted in 2015, it will be lost from 1st of April 2016 forward.
Any vacation days that were taken will be subtracted always from the earliest accumulations. Only weekdays (Mon-Fri) will be counted.
3) Your task
- Please create a basic interface that allows to enter a hire date, one or more vacation periods (with start and end date), and a calculation date (date for which to calculate the number of remaining vacation days)
- Once the "Calculation" button is pressed, calculate the remaining vacation days on "calculation date", assuming an employee was hired on the provided hire date, and took the vacations provided in the vacation period list.
- The vacation periods must be subtracted correctly when showing the remaining vacation day balance. Please make sure to only calculate working days (Mon-Fri) when calculating the length of vacation periods.
4) Evaluation
Please structure all your PHP code in a nice way, in several files and folders if necessary. Complex code statements and calculations need a comment in English. Formatting of code must be clean.


Set up resource and run url http://localhost/calculate to start.
