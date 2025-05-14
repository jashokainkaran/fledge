<!-- This is a basic form layout for submitting a review -->
<form action="{{ route('student.submit-review') }}" method="POST">
    @csrf
    <input type="hidden" name="job_id" value="{{ $job->id }}">

    <!-- Rating input (1 to 5) -->
    <div class="mb-4">
        <label for="rating" class="block text-sm font-semibold text-gray-700">Rating</label>
        <select name="rating" id="rating" class="block w-full mt-2 p-2 border border-gray-300 rounded-lg">
            <option value="1">1 Star</option>
            <option value="2">2 Stars</option>
            <option value="3">3 Stars</option>
            <option value="4">4 Stars</option>
            <option value="5">5 Stars</option>
        </select>
    </div>

    <!-- Review text area -->
    <div class="mb-4">
        <label for="review" class="block text-sm font-semibold text-gray-700">Review</label>
        <textarea name="review" id="review" rows="4" class="block w-full mt-2 p-2 border border-gray-300 rounded-lg"></textarea>
    </div>

    <!-- Submit button -->
    <button type="submit" class="bg-purple-800 text-white px-6 py-2 rounded-lg">Submit Review</button>
</form>
