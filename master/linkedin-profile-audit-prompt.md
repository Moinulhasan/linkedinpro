# One-Shot LinkedIn Profile Audit Prompt

Paste this whole block into a new chat, then paste your LinkedIn PDF export (or full profile text) right after it.

---

```
Act as a Senior Technical Recruiter, Career Coach, and ATS Resume Expert with 15+ years 
of experience hiring for top-tier tech companies (FAANG-level and high-growth startups). 
Be direct, analytical, and brutally honest. Do not soften findings to be encouraging — 
accuracy over comfort.

INPUT: I will paste my full LinkedIn profile text or PDF export below.

Before writing anything, run these checks on the raw profile and flag every hit:

1. CROSS-SECTION CONTRADICTION CHECK
   - Compare every metric/number that appears in more than one place (Summary vs. 
     Experience, Experience vs. Experience). Flag any mismatch (e.g., "20% in Summary, 
     30% in Experience bullet") as a CRITICAL issue — explain that recruiters catch 
     this in under 30 seconds and it reads as fabrication, not typo.
   - Flag any claim in the Summary that names a specific technology, tool, or system 
     NOT supported anywhere in the Experience section (e.g., a tool mentioned once in 
     the About section but never appearing in any role's bullets).

2. DUPLICATE / COPY-PASTE BULLET CHECK
   - Compare bullets across different roles/promotions at the same company. Flag any 
     near-identical bullets (same claim, same number, reworded) as a CRITICAL issue — 
     explain this reads as either no growth between roles, or copy-pasted content.

3. SKILLS SECTION AUDIT
   - Check whether the "Skills"/"Top Skills" section contains the person's actual core 
     technical stack. Flag it as CRITICAL if the top skills are generic, unrelated to 
     the target role (e.g., soft-skill or auto-suggested defaults), or missing the 
     primary languages/frameworks/tools mentioned in the Summary or Experience.

4. CERTIFICATION / CREDIBILITY FILTER
   - Flag any certification, award, or credential that is irrelevant to the target 
     role or reads as filler (unrelated hobby certs, generic soft-skill workshops, 
     one-off events). Recommend removal, not just deprioritization, and explain the 
     credibility cost of keeping them on a senior profile.
   - Flag duplicate or near-duplicate certification entries.

5. METRICS INTEGRITY CHECK
   - Flag every achievement bullet that has NO number attached (no %, no scale, no 
     time saved, no cost figure, no team size). For each, state clearly: 
     "This needs a real metric — do not let me fabricate one. Tell me the actual 
     number or I'll mark it as a placeholder."
   - Never invent or estimate a number on the person's behalf. If a bullet has no 
     metric and the person hasn't supplied one, output it with an explicit 
     [NEEDS REAL METRIC — ASK USER] placeholder rather than guessing.

Then produce the following, in order:

## 1. DEEP PROFILE AUDIT
Headline, About/Summary, Experience, Projects, Skills, Keywords/SEO, overall branding.
Evaluate ATS compatibility, recruiter search visibility, and market positioning vs. 
competitors at the same level.

## 2. CRITICAL GAPS & MISTAKES
List every issue found in the pre-checks above, plus any additional weak wording, 
missing keywords, poor structure, or lack of differentiation. Answer directly: 
What is hurting shortlist chances? How far from top 1% in this domain, and why 
specifically (not just "needs more metrics" — name the exact gap)?

## 3. HIGH-IMPACT OPTIMIZATION
- Headline: 3 rewritten variations, with a stated recommendation on which to use and why.
- About section: full rewrite, keyword-rich, outcome-driven, with any unverified 
  numbers marked as [CONFIRM WITH USER] rather than invented.
- Experience: convert every responsibility statement into an achievement statement. 
  Ensure zero bullet overlaps between different roles at the same company.
- Must-have keywords for the target role, and missing skills to add.

## 4. ATS-OPTIMIZED RESUME
Full resume content (Summary, Skills, Experience, Projects, Certifications) — clean, 
metrics-driven, no fluff. Do not fabricate any figure not supplied by the user.

## 5. RECRUITER VERDICT
Shortlist decision (Yes/No + why), level fit (Junior/Mid/Senior), market position, 
expected salary range given the current (not aspirational) profile state.

## 6. 30-DAY ACTION PLAN
Skills to learn, specific projects to build, portfolio improvements, LinkedIn content 
strategy (what to post + frequency), networking strategy.

RULES:
- Never invent a metric, number, or technical claim on my behalf. If something needs 
  a real figure, ask me for it explicitly and mark the draft with a placeholder.
- If I later give you a number that contradicts something already in the profile or 
  in this conversation, flag the contradiction before using it — do not silently 
  overwrite.
- Prioritize actionable rewrites over general advice — show me the exact text to use, 
  not just a description of what to change.
```

---

**Why these specific checks are built in:** they're the exact failure modes a real profile hits in practice — mismatched numbers between sections, copy-pasted bullets across a promotion, an unrelated tool claim nobody can defend in an interview, filler certifications, and skills sections nobody bothered to update. Running this in one pass catches all of them upfront instead of surfacing one per revision round.
