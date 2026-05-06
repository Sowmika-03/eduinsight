# Natural Language Query Examples

Quick reference for common NLP queries in EduInsight.

## Basic Queries

### Students & Attendance

```
"Show students with attendance below 60%"
→ Returns: Student names, current attendance percentage

"List all students with zero attendance"
→ Returns: Students who haven't attended any class

"Show students who are absent more than 5 times"
→ Returns: Student names and absence count

"Display attendance of Computer Science batch"
→ Returns: All students in CS batch with attendance details
```

### Marks & Performance

```
"Show top 5 students by total marks"
→ Returns: Student names ranked by marks (bar chart)

"Display students with marks below 40"
→ Returns: At-risk students for intervention

"Show average marks by course"
→ Returns: Course names with average marks

"List students who failed in any course"
→ Returns: Students with marks < 40 in any course

"Show students with marks between 70 and 85"
→ Returns: Good performers for recognition
```

### Courses & Enrollment

```
"Show all courses with enrollment count"
→ Returns: Course names, code, number of enrolled students

"Display courses with less than 20 students"
→ Returns: Under-enrolled courses

"Show courses taught by Dr. Sharma"
→ Returns: All courses assigned to specific faculty

"List students enrolled in Database and Web Development"
→ Returns: Students taking both courses
```

### Batch & Semester Analysis

```
"Show students in 2023 batch pursuing Computer Science"
→ Returns: Filtered students list

"Display overall performance of 2022 batch"
→ Returns: Average marks by batch

"Show enrollment statistics by semester"
→ Returns: Students per semester (pie chart)

"List all students in semester 4"
→ Returns: Filtered students for specific semester
```

## Advanced Queries

### Risk & Alerts

```
"Show students at high academic risk"
→ Returns: Risk level, reasons, recommendations

"Display students with low attendance AND low marks"
→ Returns: Multi-criteria risk assessment

"Show students who need urgent intervention"
→ Returns: Critical cases combining attendance + marks
```

### Comparative Analysis

```
"Compare attendance between batches"
→ Returns: Batch-wise attendance comparison (chart)

"Show which course has highest failure rate"
→ Returns: Course names ranked by failure count

"Display student performance trend over semesters"
→ Returns: Performance progression for each student
```

### Statistical Queries

```
"Show attendance distribution"
→ Returns: Pie chart of attendance ranges

"Display marks distribution by course"
→ Returns: Grade distribution (histogram)

"Show average marks vs attendance correlation"
→ Returns: Relationship between attendance and performance
```

## Supported Keywords

### Selection Keywords
- Show / Display / List
- Select / Get / Find
- Report on / Statistics for

### Conditions
- With (attendance below 60%)
- Without (any failing marks)
- More than / Less than
- Between X and Y
- Equals / Is / Has

### Aggregations
- Top / Bottom N
- Average / Total
- Count / Number of
- Maximum / Minimum

### Grouping
- By course / semester / batch
- Per faculty / department
- According to / Grouped by

## Chart Auto-Generation

The system automatically creates charts when appropriate:

### Bar Charts
```
"Show top 10 students by marks"
→ Displays bar chart with student names on X-axis

"Show enrollment by course"
→ Bar chart with course names and enrollment count
```

### Pie Charts
```
"Show student distribution by batch"
→ Pie chart showing percentage per batch (max 10 slices)

"Display program distribution"
→ Pie chart with different programs
```

### Line Charts
```
"Show attendance progress over months"
→ Line chart showing trend over time
```

## Tips for Best Results

1. **Be Specific**
   - ✓ "Show students in Computer Science with attendance below 60%"
   - ✗ "Show students"

2. **Use Clear Metrics**
   - ✓ "Attendance below 60%"
   - ✗ "Low attendance"

3. **Reference Database Fields**
   - Better: "Show students with marks between 401 and 500"
   - Avoid: "Show average students"

4. **Combine Criteria**
   - ✓ "Show students in 2023 batch pursuing CS with marks > 80"
   - ✗ "Show important students"

5. **Use Time References**
   - ✓ "Show marks for this semester"
   - ✓ "Display attendance for last month"

## Expected Results Format

All queries return results in table format with:
- Column headers (auto-formatted with proper names)
- Sortable data
- Automatic formatting for:
  - Percentages (85.50%)
  - Currency (₹5,000)
  - Dates (15 Jan 2023)

## Limitations

The following queries may not work:
- Predictions beyond current data
- Complex joins across unrelated tables
- Real-time streaming data
- Historical "what-if" scenarios

For such requirements, contact the development team.
