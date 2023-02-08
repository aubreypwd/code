tell application "System Events"
	repeat with p in (every application process whose visible is true)
		click (first button of every window of p whose role description is "minimize button")
	end repeat
end tell